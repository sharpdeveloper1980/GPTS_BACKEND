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
use App\TteUsers;
use App\User;
use App\Setting;
use App\Career;
use App\TteUserSsoAuth;
use Auth;
use Mail;
use URL;
use App\Helpers\Helper;

class TteController extends Controller {

    use HasApiTokens,
        Notifiable;
    /*

     * Save tteuser
     * @return \Illuminate\Http\Response
     *   
     */

    public function saveTteUser(Request $request) {
        try {


            $validator = Validator::make($request->all(), [
                        'first_name' => 'required',
//                'last_name' => 'required',
                        'email' => 'required|unique:tte_users,email',
                        'user_id' => 'required|unique:tte_users,student_id'
            ]);
            if ($validator->fails()) {
                return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
            } else {
                $post['first_name'] = $request->first_name;
                $post['last_name'] = $request->last_name;
                $post['email'] = $request->email;
                $post['campaign_ids'] = [1156];

                $url = 'https://www.tte-lighthouse.com/api/v1/projects/1154/users';
                $res = json_decode(Helper::con('Post', $url, $post));
                if(isset($res->id)){
                    $user = new TteUsers;
                    $user->student_id = $request->user_id;
                    $user->tte_user_id = $res->id;
                    $user->first_name = $post['first_name'];
                    $user->last_name = $post['last_name'];
                    $user->email = $post['email'];
                    $user->status = 1;
                    $user->camping_id = json_encode($post['campaign_ids']);
                    $user->created_at = date('Y-m-d h:i:s', strtotime($res->created_at));
                    $user->updated_at = date('Y-m-d h:i:s', strtotime($res->updated_at));
                    $user->save();
                }
                return response()->json(['code' => '200', 'data' => $res]);
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return response()->json($e->getErrors());
        }
    }

    /*

     * Authenticated sso url
     * @return \Illuminate\Http\Response
     *   
     */

    public function authSso(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                        'user_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
            } else {

                $user = TteUsers::where('student_id', $request->user_id)->first();
                $post['user_id'] = $user->tte_user_id;
                $url = 'https://www.tte-lighthouse.com/api/v1/projects/1154/users/' . $user->tte_user_id . '/sso';
                $res = json_decode(Helper::con('Post', $url, $post));
                //print_r($res);
                if(isset($res->assessments[0])){
                    $turl = str_replace(":3030","",$res->assessments[0]->url);
                }else{
                    $turl = '';
                }
                if (isset($res->assessments[0]) && $user->status == 1):
                    $userSso = new TteUserSsoAuth;
                    $userSso->tte_user_id = $user->tte_user_id;
                    $userSso->auth_id = $res->assessments[0]->id;
                    $userSso->tte_test_url = $turl;
                    $userSso->created_at = date('Y-m-d h:i:s');
                    if ($userSso->save()):
                        $user->status = 2;
                        $user->save();
                    endif;
                else:
                    $userSso = TteUserSsoAuth::where('tte_user_id', $user->tte_user_id)->first();
                    $userSso->tte_test_url = $turl;
                    $userSso->save();
                endif;
                
                return response()->json(['code' => '200', 'data' => $res]);
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return response()->json($e->getErrors());
        }
    }

    /*

     * Get user Report
     * @return \Illuminate\Http\Response
     *   
     */

    public function getReport(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                        'user_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
            } else {
                $res2 = array();
                $post['user_id'] = $request->user_id;
                $user = TteUsers::where('student_id', $post['user_id'])->first();
                $url = 'https://www.tte-lighthouse.com/api/v1/projects/1154/users/' . $user->tte_user_id . '/reports';
                $res = json_decode(Helper::con('Get', $url, $post));
                                    //print_r($res[0]);die();

                if (isset($res[0]->assessments[0]->status) && $res[0]->assessments[0]->status == 'completed'):
                    $url2 = 'https://www.tte-lighthouse.com/api/v1/projects/1154/users/' . $user->tte_user_id . '/reports/381/results';
                    $res2 = json_decode(Helper::con('Get', $url2, $post));
                    $careerlist = array();
                    foreach ($res2->assessments[0]->results->ranked_occupations as $key => $value) :
                        $value->slug = $this->getTTECareer($value->id, 'slug');
                        $careerInfo = $this->getCareerInfo($value->id, 'slug');
                        $value->avgfess = (isset($careerInfo->average_fees))?$careerInfo->average_fees:0;
                        $value->up = (isset($careerInfo->under_programme))?$careerInfo->under_programme:0;
                        $value->nofcollege = (isset($careerInfo->college_no))?$careerInfo->college_no:0;
                        $value->career_icon = (!empty($careerInfo->career_icon))?"https://d33umu47ssmut9.cloudfront.net/career/career-icon/" . $careerInfo->career_icon:'';
                        
                        $res2->assessments[0]->results->ranked_occupations[$key] = $value;
                    endforeach;

                    if ($user->status == 3):
                        $user->report_id = $res[0]->id;
                        $user->normed_factors = json_encode($res2->assessments[0]->results->normed_factors);
                        $user->ranked_occupations = json_encode($res2->assessments[0]->results->ranked_occupations);
                        $user->save();
                        
                    endif;
                endif;

                return response()->json(['code' => '200', 'data' => $res2]);
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return response()->json($e->getErrors());
        }
    }

    /*

     * Get user Status
     * @return \Illuminate\Http\Response
     *   
     */

    public function tteUserStatus(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                        'user_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
            } else {
                $post['user_id'] = $request->user_id;
                $user = TteUsers::where('student_id', $post['user_id'])->first();
                if ($user != '') {
                    $data['status'] = $user->status;
                    if ($user->status == 2) {
                        $authUrl = TteUserSsoAuth::where('tte_user_id', $user->tte_user_id)->first();
                        $data['url'] = $authUrl->tte_test_url;
                        $url = 'https://www.tte-lighthouse.com/api/v1/projects/1154/users/' . $user->tte_user_id . '/reports';
                        $res = json_decode(Helper::con('Get', $url, $post));
//            print_r($res[0]->assessments[0]->status);die();
                        if (isset($res[0]->assessments[0]->status) && $res[0]->assessments[0]->status == 'completed'):
                            if ($user->status != 3):
                                $user->status = 3;
                                $user->save();
//                                $this->SendTteReportMail($post['user_id']);
                            endif;
                        endif;
                    }
                }else {
                    $data['status'] = 0;
                    $data['url'] = "";
                }

                return response()->json(['code' => '200', 'data' => $data]);
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return response()->json($e->getErrors());
        }
    }

    public function getReportPdf(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                        'user_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
            } else {

                $post['user_id'] = $request->user_id;
                $user = TteUsers::where('student_id', $post['user_id'])->first();
                //print_r($user);die();
                $filename = $user->tte_user_id . 'report.pdf';
                $path = public_path('/ttreport/') . $filename;
                $report_url = URL::to('public/ttreport/') . '/' . $filename;
                if ($user->pdf_report == null || $user->pdf_report == ''):
                    $url = 'https://www.tte-lighthouse.com/api/v1/projects/1154/users/' . $user->tte_user_id . '/reports/381/pdf';
                    
                    $res = json_decode(Helper::con('Get', $url, $post));
                    if (isset($res->url) && $res->url != '' && $res->url != null):
                        file_put_contents($path, file_get_contents($res->url));
                        $data = array();
                        $data['url'] = $report_url;
                        $data['status']=1;
                        $user->pdf_report = $filename;
                        $user->save();
                    else:
                        $data['url'] = '';
                        $data['Status']=0;
                    endif;

                else:
                    $data['url'] = $report_url;
                    $data['status']=1;
                endif;

                return response()->json(['code' => '200', 'data' => $data]);
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return response()->json($e->getErrors());
        }
    }

    public function SendTteReportMail($user_id) {

        $post['user_id'] = $user_id;
        $user = TteUsers::where('student_id', $post['user_id'])->first();
        $filename = $user->tte_user_id . 'report.pdf';
        $path = public_path('/ttreport/') . $filename;
        $report_url = getcwd() . '/public/ttreport/' . $filename;
        if ($user->pdf_report == null):
            $url = 'https://www.tte-lighthouse.com/api/v1/projects/1154/users/' . $user->tte_user_id . '/reports/381/pdf';
            $res = json_decode(Helper::con('Get', $url, $post));

            file_put_contents($path, file_get_contents("http:" . $res->url));
            $user->pdf_report = $filename;
            $user->save();
        endif;
        $userData = User::whereId($post['user_id'])->first();
        $user_email = $userData->email;
        $user_name = $userData->name;
        $setting = Setting::first();
        $siteEmail = $setting->robot_email;
        $maildata = array('name' => $user_name, 'email' => $user_email, 'title' => 'TTE exam report');
        Mail::send('emails.tteresult', $maildata, function($message) use($user_email, $report_url, $siteEmail, $user_name) {
            $message->to($user_email, $user_name)->subject('TTE exam report.');
            $message->from($siteEmail, 'GPTS Admin');
            $message->attach($report_url);
        });
    }

    public function getTTECareer($id, $type) {
        $career = Career::where('tte_career_id', $id)->whereParent(0)->whereStatus(1)->first();
        if (!empty($career)):
            return $career->$type;
        else:
            return '';
        endif;
    }

    public function getCareerInfo($id, $type) {
        $career = Career::where('tte_career_id', $id)->whereParent(0)->whereStatus(1)->first();
        return $career;
    }

}
