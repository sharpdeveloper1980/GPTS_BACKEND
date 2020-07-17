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

class InstituteController extends Controller {

    use HasApiTokens,
        Notifiable;


     public function getinstitutes(){

        error_reporting(0);
        
        $query=DB::select("SELECT user.id,user.name,user.logo,detail.video,detail.cover,detail.thumbnail FROM univ_users user INNER JOIN univ_details detail ON user.id=detail.user_id WHERE user.status=1");

        $result=array();
        foreach($query as $row){
            $data['id']=$row->id;
            $data['name']=$row->name;

            if($row->logo){
                $data['logo'] = 'https://greatplacetostudy.com/institute/public/uploads/users/'.$row->id.'/logo/thumb'.'/'.$row->logo;
            }else{
                $data['logo'] = '';
            }

            if($row->video){
                $data['master_video'] = "https://d33umu47ssmut9.cloudfront.net/institute/".$row->id."/master_video/".$row->video;
            }else{
                $data['master_video'] = '';
            }
            
            if($row->cover){
                $data['master_cover'] = "https://d33umu47ssmut9.cloudfront.net/institute/".$row->id."/master_video/org/".$row->cover;
            }else{
                $data['master_cover'] = '';
            }

            if($row->thumbnail){
                $data['thumbnail'] = "https://d33umu47ssmut9.cloudfront.net/institute/".$row->id."/master_video/vertical/".$row->thumbnail;
            }else{
                $data['thumbnail'] = '';
            }
            
            $result[]=$data;
        }
        
        return response()->json(['code' => '200', 'institutes' => $result]);
    }

    public function getSingleInstitute(Request $request,$id){
        
        error_reporting(0);
        if($id){
                
            // Common Details
            $query=DB::select("SELECT user.id,user.name,user.logo,detail.about,detail.fdn_year,detail.address,detail.area,detail.students,detail.facilities,detail.brochure,detail.video,detail.cover FROM univ_users user INNER JOIN univ_details detail ON user.id=detail.user_id WHERE detail.user_id='".$id."' AND  user.status=1");
                
            $chus_query=DB::select("SELECT heading,description FROM univ_choose_us WHERE user_id=".$id." ORDER BY sort ASC");
            $result1=array();
            foreach($chus_query as $row){
                $data1['heading']=$row->heading;
                $data1['description']=$row->description;
                    
                $result1[]=$data1;
            }
            
            // Testimonials
            $t_query=DB::select("SELECT id,type,full_name,designation,profile_pic,statement,video FROM univ_testimonials WHERE user_id=".$id." ORDER BY sort ASC");
            $result2=array();
            foreach($t_query as $row){
                $data2['type']=$row->type;
                $data2['full_name']=$row->full_name;
                $data2['designation']=$row->designation;

                if($row->profile_pic){
                    $data2['profile_pic'] = 'https://greatplacetostudy.com/institute/public/uploads/users/'.$id.'/testimonials/thumb'.'/'.$row->profile_pic;
                }else{
                    $data2['profile_pic'] = '';
                }

                if($row->video){
                    $data2['video'] = "https://d33umu47ssmut9.cloudfront.net/institute/".$id."/testimonials/".$row->video;
	            }else{
	                $data2['video'] = '';
	            }

                $data2['statement']=$row->statement;
                	
                $result2[]=$data2;
            }

            if($result2)
            {
            	$test_array1=array();
            	$test_array2=array();

            	foreach($result2 AS $row){
            		if($row['type']==1){

            			$dd['full_name']=$row['full_name'];
            			$dd['designation']=$row['designation'];
            			$dd['statement']=$row['statement'];
                		$dd['profile_pic']=$row['profile_pic']; 

            			$test_array1[]=$dd;
            		}else
            		if($row['type']==2){

            			$ddr['video']=$row['video'];
            			
            			$test_array2[]=$ddr;
            		}
            	}
            }

            $testimonials_array['textual']=$test_array1;
            $testimonials_array['video']=$test_array2;
            
            
            // Recruiters
            $rec_query=DB::select("SELECT id,name,logo FROM univ_recruiters WHERE user_id=".$id." ORDER BY sort ASC");
            $result3=array();
            foreach($rec_query as $row){
                $data3['name']=$row->name;

                if($row->logo){
                    $data3['logo'] = 'https://greatplacetostudy.com/institute/public/uploads/users/'.$id.'/recruiters/thumb'.'/'.$row->logo;
                }else{
                    $data3['logo'] = '';
                }
                
                $result3[]=$data3;
            }
            
            // Video Library
            $vl_query=DB::select("SELECT name,video,vcover,banner,about FROM univ_video_library WHERE user_id=".$id." ORDER BY sort ASC");
            $result4=array();
            foreach($vl_query as $row){
                
                $data4['name']=$row->name;
               	
                $data4['about']=$row->about;
                
                if($row->video){
                    $data4['video'] = "https://d33umu47ssmut9.cloudfront.net/institute/".$id."/".$row->video;
                }else{
                    $data4['video'] = '';
                }
                
                if($row->vcover){
                    $data4['vcover'] = "https://d33umu47ssmut9.cloudfront.net/institute/".$id."/org/".$row->vcover;
                }else{
                    $data4['vcover'] = '';
                }
				
				if($row->vcover){
                    $data4['banner'] = "https://d33umu47ssmut9.cloudfront.net/institute/".$id."/org/".$row->banner;
                }else{
                    $data4['banner'] = '';
                }

                $result4[]=$data4;
            }
            
            
            // Scholarships
            $sch_query=DB::select("SELECT id,title,about,DATE_FORMAT(deadline, '%d %M, %Y') AS deadline,brochure,eligibility FROM univ_scholarships WHERE user_id=".$id." ORDER BY sort ASC");
            $result5=array();
            foreach($sch_query as $row){
                $data5['name']=$row->title;
                $data5['about']=$row->about;
                $data5['deadline']=$row->deadline;
                $data5['eligibility']=$row->eligibility;

                $schprocess_query=DB::select("SELECT title FROM univ_scholar_process WHERE user_id=".$id." AND scholarship_id='".$row->id."'");
                $res15=array();
                foreach($schprocess_query as $row1){
                	$data16['title']=$row1->title;
                	
                	$res15[]=$data16;
                }

                $data5['process']=$res15;

                if($row->brochure){
                    $data5['brochure'] = 'https://greatplacetostudy.com/institute/public/uploads/users/'.$id.'/brochure/'.$row->brochure;
                }else{
                    $data5['brochure'] = '';
                }
                
                $result5[]=$data5;
            }
            
            $result=array();
            foreach($query as $row){
                $data['id']=$row->id;
                $data['name']=$row->name;
                $data['about']=$row->about;
                $data['foundation_year']=$row->fdn_year;
                $data['address']=$row->address;
                $data['area']=$row->area;
                $data['total_students']=$row->students;
                $data['facilities']=$row->facilities;

                if($row->logo){
                    $data['logo'] = 'https://greatplacetostudy.com/institute/public/uploads/users/'.$id.'/logo/thumb'.'/'.$row->logo;
                }else{
                    $data['logo'] = '';
                }
                
                if($row->brochure){
                    $data['brochure'] = 'https://greatplacetostudy.com/institute/public/uploads/users/'.$id.'/brochure'.'/'.$row->brochure;
                }else{
                    $data['brochure'] = '';
                }

                if($row->video){
                    $data['master_video'] = "https://d33umu47ssmut9.cloudfront.net/institute/".$id."/master_video/".$row->video;
                }else{
                    $data['master_video'] = '';
                }
                
                if($row->cover){
                    $data['master_cover'] = "https://d33umu47ssmut9.cloudfront.net/institute/".$id."/master_video/org/".$row->cover;
                }else{
                    $data['master_cover'] = '';
                }

                $result['details']=$data;
                $result['choose_us']=$result1;
                $result['testimonials']=$testimonials_array;
                $result['recruiters']=$result3;
                $result['video_library']=$result4;
            	$result['scholarships']=$result5;
            }

            return response()->json(['code' => '200', 'institutes' => $result]);
            
        }else{
    		return response()->json(['code' => '200', 'msg' => "User id not found."]);
        }
    }

    public function getStreams(Request $request,$id){
		error_reporting(0);
    	    
		$query=DB::select("SELECT id,name FROM `univ_stream` WHERE id IN(SELECT DISTINCT stream FROM `univ_courses` WHERE user_id='".$id."')");

		return response()->json(['code' => '200', 'stream' => $query]);
    }

    public function getCourses(Request $request,$id,$stream_id){
    	error_reporting(0);
            
        if($id){
            	
            $res_stream=DB::select("SELECT name FROM `univ_stream` WHERE id='$stream_id'");

        	$res_substream=DB::select("SELECT id,name FROM `univ_course_type` WHERE stream_id='$stream_id'");

            $result=array();
            foreach($res_substream AS $substream){
                $data['sub_id']=$substream->id;  
                $data['sub_stream']=$substream->name;

                $query1=DB::select("SELECT id,stream,course_name,about,duration,total_fees,study_mode,entrance_exam,eligibility FROM univ_courses WHERE user_id='".$id."' AND substream='".$substream->id."' ORDER BY sort ASC");

                $result1=array();
                foreach($query1 as $row){
                    $data1['id']=$row->id;
                    $data1['stream']=$row->stream;
                    $data1['course_name']=$row->course_name;
                    $data1['about']=$row->about;
                    $data1['duration']=$row->duration;
                    $data1['total_fees']=$row->total_fees;
                    
                    if($row->study_mode==1){
                        $data1['study_mode']="Full Time";
                    }else
                    if($row->study_mode==2){
                        $data1['study_mode']="Part Time- Classroom";
                    }else
                    if($row->study_mode==3){
                        $data1['study_mode']="Distance / Correspondence";
                    }

                    $data1['entrance_exam']=$row->entrance_exam;
                    $data1['eligibility']=$row->eligibility;
                        
                    $result1[]=$data1;
                }

                $data['courses']=$result1;
                $result[]=$data;
            }
            
            $result2=array();
            foreach($result AS $row){
                if($row['courses']){
                    $data['sub_id']=$row['sub_id'];
                    $data['sub_stream']=$row['sub_stream'];
                    $data['courses']=$row['courses'];

                    $result2[]=$data;        
                }
            }

            return response()->json(['code' => '200','stream'=>$res_stream[0]->name,'data' => $result2]);
        }
    }

    public function suggestedInst(Request $request,$id){
        $query=DB::select("SELECT users.id,users.name,details.cover FROM univ_users AS users INNER JOIN univ_details AS details ON users.id=details.user_id WHERE users.id!=$id");
        
        foreach($query AS $row)
        {
            $data['institute_id']=$row->id;
            $data['name']=$row->name;
            $data['image']=($row->cover!='') ? "https://d33umu47ssmut9.cloudfront.net/institute/".$row->id."/master_video/org/".$row->cover : "";
            
            $result[]=$data;
        }

        return response()->json(['code' => '200','data' => $result]);
    }
}
