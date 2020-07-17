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
use App\College;
use Carbon\Carbon;
use App\Setting;
use App\CollegeGallery;
use App\FacilitiesIcon;
use Auth;
use Mail;

class CollegeController extends Controller {

    use HasApiTokens,
        Notifiable;
    /*
      |--------------------------------------------------------------------------
      | College Registration
      |--------------------------------------------------------------------------
      |
     */

    public function collegeRegistration(Request $request) {
        Validator::extend('valid_username', function($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $validator = Validator::make($request->all(), [
                    'location' => 'required',
                    'username' => 'required|valid_username|min:4|max:8|unique:gpts_college,user_name',
                    'mobile_no' => 'required|min:10|max:10|unique:users,contact',
                    'dean_name' => 'required',
                    'dean_email_id' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {

            $updatecontact = User::whereId($request->user_id)->update(['contact' => $request->mobile_no]);
            $userdata = User::whereId($request->user_id)->first();
            $allData = array();
            try {
                $query = new College;
                $query->user_id = $request->user_id;
                $query->user_name = $request->username;
                $query->university_affiliated = $request->university_affiliated;
                $query->collage_type = $request->college_type;
                $query->location = $request->location;
                $query->phone_no = $request->phone_no;
                $query->dean_name = $request->dean_name;
                $query->dean_email_id = $request->dean_email_id;
                $query->department = $request->department;
                $query->designation = $request->designation;
                $query->address = $request->college_address;
                $query->pincode = $request->college_pincode;
                $query->country = $request->college_country;
                $query->save();
                // Set new attribute into object
                $query->setAttribute('contact', $userdata->contact);
                return response()->json(['code' => '200', 'data' => $userdata]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    /*
      |--------------------------------------------------------------------------
      | University Registration
      |--------------------------------------------------------------------------
      |
     */

    public function universityRegistration(Request $request) {

        Validator::extend('valid_username', function($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });
        $messages = [
            'vc_name.required' => 'Name of Vice Chancellor is required',
            'vc_email_id.required' => 'Email id of Vice Chancellor is required',
            'vc_email_id.email' => 'Invalid email id of Vice Chancellor',
            'website.required' => 'Website url is required',
                //'website.url'			=>	'Invalid webiste url'
        ];
        $regex = '/^(www.\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $validator = Validator::make($request->all(), [
                    'location' => 'required',
                    'username' => 'required|valid_username|min:4|max:8|unique:gpts_college,user_name',
                    'mobile_no' => 'required|min:10|max:10|unique:users,contact',
                    'vc_name' => 'required',
                    'vc_email_id' => 'required|email',
                    'website' => 'required|active_url',
                        ], $messages);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {

            $updatecontact = User::whereId($request->user_id)->update(['contact' => $request->mobile_no]);
            $userdata = User::whereId($request->user_id)->first();
            $allData = array();
            try {
                $query = new College;
                $query->user_id = $request->user_id;
                $query->user_name = $request->username;
                $query->year_of_build = $request->year_of_build;
                $query->location = $request->location;
                $query->vc_name = $request->vc_name;
                $query->vc_email_id = $request->vc_email_id;
                $query->phone_no = $request->phone_no;
                $query->website = $request->website;
                $query->department = $request->department;
                $query->designation = $request->designation;
                $query->save();
                // Set new attribute into object
                $query->setAttribute('contact', $userdata->contact);
                return response()->json(['code' => '200', 'data' => $userdata]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Get College Profile
      |--------------------------------------------------------------------------
      |
     */

    public function getCollegProfile(Request $request) {

        try {

            $slug = $request->slug;
            $query = College::with('collegeType', 'collegeWhyChoose', 'collegeProminent', 'collegeAlumini', 'collegeFacilities')->whereSlug($slug)->first();
            $basicInfo = User::whereId($query->user_id)->first();
            $allResult = array();
            //print_r($query->collegeType->toArray());die();
            // Basic info
            $collegeProfile = $query->collegeType->toArray();
            $data['name'] = $basicInfo->name;
            $data['college_type'] = $collegeProfile['name'];
            $data['email'] = $basicInfo->email;
            $data['contact'] = $basicInfo->contact;
            $data['website'] = $query->website;
            $data['landline_no'] = $query->landline_no;
            $data['alternative_no'] = $query->alternative_no;
            $data['landline_no'] = $query->landline_no;
            $data['average_package_offer'] = $query->average_package_offer;
            $data['address'] = $query->address;
            $data['logo'] = (!empty($query->logo)) ? url('/public/image/logo/' . $query->logo) : '';
            $data['cover_logo'] = (!empty($query->cover_logo)) ? url('/public/image/coverimg/' . $cover_logo) : '';
            $data['about'] = $query->about;
            $allResult['basic_info'] = $data;

            // Satisfaction Report
            $satfac['infrastructure'] = $query->infrastructure;
            $satfac['life_on_capm'] = $query->life_on_capm;
            $satfac['learn_exp'] = $query->learn_exp;
            $satfac['extra_curr'] = $query->extra_curr;
            $satfac['happi_quot'] = $query->happi_quot; //satisfaction-report
            $satfac['report'] = (!empty($query->ssi_report)) ? url('/public/sop/' . $query->ssi_report) : '';
            $allResult['satisfaction_report'] = $satfac;

            // Why choose college
            $whyChooseinst = $query->collegeWhyChoose->toArray();
            foreach ($whyChooseinst as $key) {
                $dataval['title'] = $key['text'];
                $dataval['description'] = $key['descr'];
                $allResult['whychoose'][] = $dataval;
            }

            // Prominent
            $prominent = $query->collegeProminent->toArray();
            foreach ($prominent as $key) {
                $datapro['compy_name'] = $key['compy_name'];
                $datapro['av_salary'] = $key['av_salary'];
                $datapro['img'] = (!empty($key['logo'])) ? url('/public/image/recruiters_image/' . $key['logo']) : '';
                $allResult['prominent'][] = $datapro;
            }

            // Alumini
            $alumini = $query->collegeAlumini->toArray();
            foreach ($alumini as $key) {
                $dataalumini['title'] = $key['title'];
                $dataalumini['alumni_desc'] = $key['alumni_desc'];
                $dataalumini['img'] = (!empty($key['alumni_desc'])) ? url('/public/image/alumni_pic/' . $key['alumni_desc']) : '';
                $allResult['alumini'][] = $dataalumini;
            }

            $facilities = $query->collegeFacilities->toArray();
            foreach ($facilities as $key) {
                $datafact['icon'] = (!empty($key['icon'])) ? url('/public/image/renowned_faculties/' . $key['icon']) : '';
                $datafact['fac_name'] = $key['fac_name'];
                $allResult['facilities'][] = $datafact;
            }


            //return json_encode($allResult);
            return response()->json(['code' => '200', 'data' => $allResult]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Get College Gallery
      |--------------------------------------------------------------------------
      |
     */

    public function getGallery(Request $request) {

        try {

            $slug = $request->slug;
            $college_id = $this->getCollegeId($slug);
            $query = CollegeGallery::whereCollegeId($college_id->user_id)->get();
            $allResult = array();
            foreach ($query as $key) {
                $data['img'] = (!empty($key['img'])) ? url('/public/image/gallery/' . $key['img']) : '';
                $allResult[] = $data;
            }

            //return json_encode($allResult);
            return response()->json(['code' => '200', 'data' => $allResult]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Get College Scholarship
      |--------------------------------------------------------------------------
      |
     */

    public function getscholarship(Request $request) {

        try {

            $slug = $request->slug;
            $college_id = $this->getCollegeId($slug);
            if(isset($request->slug)){
                    $query = Scholarship::whereCollegeId($college_id->user_id)->get();
            }else{
                    $query = Scholarship::get();
            };
            $allResult = array();
            foreach ($query as $key) {
                $data['scholar_offer'] = $key->scoller_offer;
                $data['eligibility_criteria'] = $key->eligibility_criteria;
                $data['appli_process'] = $key->appli_process;
                $data['download_appli'] = (!empty($key['img'])) ? url('/public/image/gallery/' . $key['img']) : '';
                $data['last_date_to_appli'] = $key->last_date_to_appli;
                $allResult[] = $data;
            }

            //return json_encode($allResult);
            return response()->json(['code' => '200', 'data' => $allResult]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }

    public function getCollegeId($slug) {
        $query = College::whereSlug($slug)->first();
        return $query->user_id;
    }
    
    /*
      |--------------------------------------------------------------------------
      | Get facilities list
      |--------------------------------------------------------------------------
      |
     */
    public function getfacilities() {
            $facilities = FacilitiesIcon::select('title')->get();
            
          return response()->json(['code' => '200', 'data' => $facilities]);
    }

}
