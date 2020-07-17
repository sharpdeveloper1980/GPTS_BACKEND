<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
Use Redirect;
use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use App\Helpers\Helper;

class CounsellorController extends Controller {

    use HasApiTokens,
        Notifiable;


    public function index(){

        error_reporting(0);

        $school_assign=$_REQUEST['assign_id'];
        
        $query=DB::select("SELECT u.id,u.name,u.lastname,u.email,u.contact,st.gender,tte.pdf_report,tte.tte_user_id,DATE_FORMAT(tte.created_at,'%e %b, %Y') AS created_at,tte.status AS tte_status,st.grade
        FROM `gpts_licence_code` lc
        INNER JOIN gpts_student st ON lc.student_assign=st.user_id
        INNER JOIN users u ON u.id=st.user_id
        INNER JOIN tte_users tte ON tte.student_id=st.user_id
        WHERE lc.school_assign=$school_assign AND lc.student_assign!=0 AND u.usertype=1 ORDER BY tte.id DESC");

        $result=array();
        foreach($query as $row){
            $data['first_name']=ucwords(strtolower($row->name));
            $data['last_name']=ucfirst(strtolower($row->lastname));
            $data['gender']=$row->gender;
            $data['email_id']=$row->email;
            $data['class']=$row->grade;
            $data['contact_no']=$row->contact;
            $data['created_at']=$row->created_at;
            $data['tte_user_id']=$row->tte_user_id;
            $data['tte_status']=$row->tte_status;

            $tte_report_pdf=asset('/public/ttreport')."/".$row->pdf_report;
            $data['tte_report_pdf']=$tte_report_pdf;

            if(file_exists($tte_report_pdf)){
                $data['pdf_report'] = $tte_report_pdf;
            }else{
                if($row->tte_user_id){
                    /* $url = "https://www.tte-lighthouse.com/api/v1/projects/1154/users/".$row->tte_user_id."/reports/381/pdf";
                    $res = json_decode(Helper::con('Get', $url,''));
                    if(isset($res->url) && $res->url != '' && $res->url != null){
                        $data['pdf_report'] = $res->url;
                    }else{
                        $data['pdf_report'] = '';
                    } */
                }else{
                    $data['pdf_report'] = '';
                }
            }

            $result[]=$data;
        }

        return response()->json(['code' => '200', 'students' => $result]);
    }

    public function getreport(Request $request){
        $tte_user_id=$request->tte_user_id;

        if($tte_user_id){
            $url = "https://www.tte-lighthouse.com/api/v1/projects/1154/users/".$tte_user_id."/reports/381/pdf";
            $res = json_decode(Helper::con('Get', $url,''));
            
            if(isset($res->url) && $res->url != '' && $res->url != null){
                $pdf_report = $res->url;
            }else{
                $pdf_report = '';
            }

            return response()->json(['code' => '200', 'report' => $pdf_report]);

        }else{
            return response()->json(['code' => '200', 'msg' => 'TTE id is mandatory.']);
}
    }

}
