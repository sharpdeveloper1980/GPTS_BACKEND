<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Http\Request;
use App\User;
use App\Country;
use App\Contact;
use App\State;
use App\Sop;
use App\College;
use App\CollegeType;
use App\Department;
use App\HomeVideo;
use App\OurTeam;
use App\SopAnswer;
use GuzzleHttp\Client;
use URL;
use Mail;
use App\Setting;
use App\FeaturedVideo;
use App\CareerLibaryVideo;
use App\Career;
use App\TTECareer;

class CommonController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Get country list
    |--------------------------------------------------------------------------
    |
    */
    public function getCountry(Request $request)
    {
        $country = Country::select('id', 'country_name')->where(['status' => 1])->orderBY('country_name', 'ASC')->get();
        if ($country->count() > 0) {
            return json_encode(array('msg' => 'Successfully Fetch the data', 'code' => '200', 'data' => $country));
        } else {
            return json_encode(array('msg' => 'Error while fetching the data', 'code' => '500', 'data' => $country));
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Get State
    |--------------------------------------------------------------------------
    |
    */
    public function getState(Request $request)
    {
        $state = State::select('id', 'name')->whereCountryId($request->country)->orderBY('name', 'ASC')->get();
        if ($state->count() > 0) {
            return json_encode(array('msg' => 'Successfully Fetch the data', 'code' => '200', 'data' => $state));
        } else {
            return json_encode(array('msg' => 'Error while fetching the data', 'code' => '500', 'data' => $state));
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Get Defualt Text SOP
    |--------------------------------------------------------------------------
    |
    */
    public function getDefaultTextSop(Request $request)
    {
        try {
            $query = Sop::whereSopType('text')->whereCreated_by('admin')->orderByDesc('created_at')->first();
            $sopAnswer = SopAnswer::select('answer')->whereUserId($request->user_id)->whereSopid($query->id)->first();
            $query['answer'] = (isset($sopAnswer->answer)) ? $sopAnswer->answer : '';
            //                        $query = Sop::whereCreatedBy('admin')->whereSopType('text')->first();
            //          $sopAnswer  = SopAnswer::whereUserId($request->user_id)->whereSopid($query->id)->first();
            //          $answer     = (isset($sopAnswer->answer))?$sopAnswer->answer:'';
            //          $query->setAttribute('text_sop', $answer);
            return json_encode(['code' => '200', 'data' => $query]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Get Defualt Video SOP
    |--------------------------------------------------------------------------
    |
    */
    public function getDefaultVideoSop(Request $request)
    {
        try {
            $query = Sop::whereCreatedBy('admin')->whereSopType('video')->first();
            $sopAnswer = SopAnswer::whereUserId($request->user_id)->whereSopid($query->id)->first();
            $answer = (isset($sopAnswer->filename)) ? $sopAnswer->filename : '';
            $getFilePath = (isset($sopAnswer->filename)) ? URL::to('/') . '/public/sop/' . $answer : '';
            $query->setAttribute('video_sop', $getFilePath);
            return json_encode(['code' => '200', 'data' => $query]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Get Cpllege Type
    |--------------------------------------------------------------------------
    |
    */
    public function getCollegeType()
    {
        try {
            $query = CollegeType::get();
            return json_encode(['code' => '200', 'data' => $query]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Get Department
    |--------------------------------------------------------------------------
    |
    */
    public function getDepartment()
    {
        try {
            $query = Department::get();
            return json_encode(['code' => '200', 'data' => $query]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Get University
    |--------------------------------------------------------------------------
    |
    */
    public function getUniversity()
    {
        try {
            $query = College::whereUsertype(3)->get();
            return json_encode(['code' => '200', 'data' => $query]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Get School
    |--------------------------------------------------------------------------
    |
    */
    public function getSchool()
    {
        try {
            $query = User::whereUsertype(4)->get();

            return json_encode(['code' => '200', 'data' => $query]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Get Blog
    |--------------------------------------------------------------------------
    |
    */
    public function getAllPost(Request $request)
    {
        // Recent Blogs
        $client = new \GuzzleHttp\Client();
        $request = $client->get('localhost:8080/cdap/b-gpts.com/b-code/gpts_blogs_api.php');
        $recent_blogs = (string) $request->getBody();
        $recent_blogs = json_decode($recent_blogs, true);
        return json_encode(['code' => '200', 'data' => $recent_blogs]);
        //return view('home',['recent_blogs'=>$recent_blogs]);
    }
    /*
    * get static video by type
    *
    */
    public function getHomeVideo(Request $request)
    {
        $video = HomeVideo::wheretype($request->type)->first();
        $video['video_thumb'] = "https://d33umu47ssmut9.cloudfront.net/home-video/" . $video->video_thumb;
        $video['video'] = "https://d33umu47ssmut9.cloudfront.net/home-video/" . $video->video;
        return json_encode(['code' => '200', 'data' => $video]);
    }
    /*
    * get random college video
    *
    */
    public function getHomeCollegeVideo()
    {

        // $college    =   array();
        $query = User::select('gpts_college.thumb', 'gpts_college.video', 'users.name', 'gpts_college.address')->whereUsertype(2)
            ->join('gpts_college', 'gpts_college.user_id', '=', 'users.id')
            ->get()
            ->random(1);
        $colleg['thumb']         = (!empty($query[0]->thumb)) ? "https://d33umu47ssmut9.cloudfront.net/college-video/video/" . $query[0]->thumb : '';
        $colleg['video']         = (!empty($query[0]->thumb)) ? "https://d33umu47ssmut9.cloudfront.net/college-video/thumb/" . $query[0]->video : '';
        $colleg['name']          =  $query[0]->name;
        $colleg['address']       =  $query[0]->address;
        return json_encode(['code' => '200', 'data' => $colleg], JSON_PRETTY_PRINT);
    }
    /*
    * get random career video
    *
    */
    public function getHomeCareerVideo()
    {

        // $query  =   TTECareer::select('gpts_tte_career_list.tte_career_id','gpts_tte_career_list.name','lib.career_icon','lib.video_thumb','lib.exp_video')
        //             ->LeftJoin('gpts_career_library as lib','lib.tte_career_id','=','gpts_tte_career_list.tte_career_id')
        //             ->get()->random(1);
        // $colleg['thumb']         = (!empty($query[0]->video_thumb))?"https://d33umu47ssmut9.cloudfront.net/career/career-thumb/" . $query[0]->video_thumb:'';
        // $colleg['video']         = (!empty($query[0]->video_thumb))?"https://d33umu47ssmut9.cloudfront.net/career/career-video/" . $query[0]->exp_video:'';
        // $colleg['name']          =  $query[0]->name;
        $query = HomeVideo::whereIn('type', [4, 5, 6])
            ->get();
        $data = array();
        foreach ($query as $key) {
            $video['video_thumb'] = "https://d33umu47ssmut9.cloudfront.net/home-video/" . $key->video_thumb;
            $video['video'] = "https://d33umu47ssmut9.cloudfront.net/home-video/" . $key->video;
            $video['title'] =   $key->title;
            $data[] = $video;
        }

        return json_encode(['code' => '200', 'data' => $data], JSON_PRETTY_PRINT);
    }
    public function getGLIVideo()
    {
        $query = HomeVideo::whereIn('type', [7])
            ->get();
        $data = array();
        foreach ($query as $key) {
            $video['video_thumb'] = "https://d33umu47ssmut9.cloudfront.net/home-video/" . $key->video_thumb;
            $video['video'] = "https://d33umu47ssmut9.cloudfront.net/home-video/" . $key->video;
            $video['title'] =   $key->title;
            $data[] = $video;
        }

        return json_encode(['code' => '200', 'data' => $data], JSON_PRETTY_PRINT);
    }
    /*
    * Save contact detail
    *
    */
    public function saveContactDetail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'contact_type' => 'required',
                'contact' => 'required|numeric|min:10',
                'message' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
            } else {
                $contact = new Contact();
                $contact->name = $request->name;
                $contact->email = $request->email;
                $contact->contact_type = $request->contact_type;
                $contact->contact = $request->contact;
                $contact->message = $request->message;
                $contact->save();
                $setting = Setting::first();
                $siteEmail = $setting->robot_email;
                $adminEmail = $setting->admin_email;
                $maildata = array('name' => $request->name, 'email' => $request->email, 'contact' => $request->contact, 'msg' => $request->message, 'title' => 'New Contact Request');
                Mail::send('emails.contactusadmin', $maildata, function ($message) use ($siteEmail, $adminEmail) {
                    $message->to($adminEmail, 'GPTS Admin')->subject('New Contact Request');
                    $message->from($siteEmail, 'GPTS Admin');
                });
                $userEmail = $request->email;
                $userName = $request->name;
                $data = array('name' => $request->name, 'title' => 'Approve your contact request');
                Mail::send('emails.contactususer', $data, function ($message) use ($siteEmail, $userEmail, $userName) {
                    $message->to($userEmail, $userName)->subject('Approve your contact request');
                    $message->from($siteEmail, 'GPTS Admin');
                });
                return response()->json(['code' => '200', 'message' => 'Thank you for contacting us one of our support team will contact you soon!']);
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return response()->json($e->getErrors());
        }
    }
    public function getFeaturedVideo()
    {
        try {
            $sessionlist = array(
                "GREAT INDIAN SCHOOLS" => "GREAT INDIAN <span>SCHOOLS</span>",
                "GREAT INDIAN INSTITUTES" => "GREAT INDIAN <span>INSTITUTES</span>",
                "EDUCATION EVANGELIST OF INDIA" => "EDUCATION <span>EVANGELIST</span> OF INDIA"
            );
            $textlist = array(
                "GREAT INDIAN SCHOOLS" => "Great Place To Study partnered with India Today and Republic TV to telecast 2 successful seasons of ‘Great Indian Schools’. The television series has showcased pre-eminent schools in India and celebrated institutes that are currently leading the change in the Indian education system.",
                "GREAT INDIAN INSTITUTES" => "Many institutions are doing a great job educating young minds and encouraging them to learn and explore new career paths. To showcase these institutions that are setting new benchmarks for education in the country, Great Indian Institutes was launched. GPTS teamed up with CNBC TV18, Republic TV to bring these amazing institutions into the limelight. The show has enjoyed excellent viewership and has become one of the prominent television series.",
                "EDUCATION EVANGELIST OF INDIA" => "As education branding pioneers in India, Great Place To Study introduced the first television series that focuses on institutions and the quality of education. The show was launched in collaboration with ET Now and Times Now to conceptualise a television series that focused on factors that make a school a great place to study. It specifically focused on aspects like learning experience, life on campus, teacher-student relationship, school vision and leadership, dynamic teaching models, and special school programmes among others. The show received excellent response from the education fraternity."
            );
            $datalist = array();
            foreach ($sessionlist as $key => $value) :
                $item['title'] = $value;
                $item['desc'] = $textlist[$key];
                $item['list'] = $this->getFeaturedVideoList($key);
                $datalist[] = $item;
            endforeach;
            return json_encode(['code' => '200', 'data' => $datalist]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }
    public function getFeaturedVideoList($title)
    {
        $query = FeaturedVideo::whereStatus(1)->whereTitle($title)->get();
        $list = array();
        foreach ($query as $key => $value) :
            $item['name'] = $value['name'];
            $item['location'] = $value['location'];
            $item['thumb'] = (isset($value->thumb)) ? URL::to('/') . '/public/thumbnail_images/' . $value->thumb : '';
            $item['video_link'] = $value['video_link'];
            $list[] = $item;
        endforeach;
        return $list;
    }
    public function SendProductInfoMail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'contact' => 'required|numeric|min:10',
                'hearaboutus' => 'required',
                'lookingFor' => 'required',
                'message' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
            } else {
                $name = $request->name;
                $email = $request->email;
                $contact = $request->contact;
                $hearaboutus = $request->hearaboutus;
                $lookingFor = $request->lookingFor;
                //$message        =   $request->message;
                $setting = Setting::first();
                $siteEmail = $setting->robot_email;
                $adminEmail = $setting->admin_email;
                $maildata = array('name' => $request->name, 'email' => $request->email, 'contact' => $request->contact, 'msg' => $request->message, 'hearaboutus' => $hearaboutus, 'lookingFor' => $lookingFor, 'title' => 'Produuct Inquiry');
                // Sent mail to admin
                Mail::send('emails.productadmininfo', $maildata, function ($message) use ($siteEmail, $adminEmail) {
                    $message->to($adminEmail, 'GPTS Admin')->subject('Product Inquiry');
                    $message->from($siteEmail, 'GPTS Admin');
                });
                // Sent mail to user
                $userEmail = $request->email;
                $userName = $request->name;
                $data = array('name' => $request->name, 'title' => 'Product Inquiry - GPTS');
                Mail::send('emails.productinfo', $data, function ($message) use ($siteEmail, $userEmail, $userName) {
                    $message->to($userEmail, $userName)->subject('Product Inquiry - GPTS');
                    $message->from($siteEmail, 'GPTS Admin');
                });
                return response()->json(['code' => '200', 'message' => 'Thank you for contacting us. We will contact you soon!']);
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return response()->json($e->getErrors());
        }
    }
    public function getStarRating()
    {
        $endpoint = "http://greatplacetostudy.org/gli-schools";
        $client = new \GuzzleHttp\Client();
        $request = $client->get($endpoint);
        $recent_blogs = (string) $request->getBody();
        $recent_blogs = json_decode($recent_blogs, true);
        if (isset($recent_blogs['Residential'])) {
            foreach ($recent_blogs['Residential'] as $key => $value) :
                $value['rating'] = $this->getStartRate($value['rating']);
                $recent_blogs['Residential'][$key] = $value;
            endforeach;
        }
        if (isset($recent_blogs['ResidentialDaycare'])) {
            foreach ($recent_blogs['ResidentialDaycare'] as $key => $value) :
                $value['rating'] = $this->getStartRate($value['rating']);
                $recent_blogs['ResidentialDaycare'][$key] = $value;
            endforeach;
        }

        if (isset($recent_blogs['Daycare'])) {
            foreach ($recent_blogs['Daycare'] as $key => $value) :
                $value['rating'] = $this->getStartRate($value['rating']);
                $recent_blogs['Daycare'][$key] = $value;
            endforeach;
        }
        return json_encode(['code' => '200', 'data' => $recent_blogs]);
    }

    public function getStartRate($rate)
    {
        $first = 1;
        $second = 1.89;
        $third = 1.90;
        $fourth = 3.50;
        $fifth = 3.51;
        $sixt = 4.39;
        $sevent = 4.40;
        $eight = 4.75;
        $nine = 4.76;
        $tenth = 5.00;
        if ($rate >= $first && $rate <= $second) {
            return 1;
        } elseif ($rate >= $third && $rate <= $fourth) {
            return 2;
        } elseif ($rate >= $fifth && $rate <= $sixt) {
            return 3;
        } elseif ($rate >= $sevent && $rate <= $eight) {
            return 4;
        } elseif ($rate >= $nine && $rate <= $tenth) {
            return 5;
        }
    }

    public function getZohoOpeningJobs(Request $request)
    {
        $token = "b10d2594578c5481cdad0609788db5f2";
        $url = "https://recruit.zoho.com/recruit/private/json/JobOpenings/getRecords?authtoken=" . $token . "&scope=recruitapi";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result, true);
        //         echo'<pre>'; print_r($data);die();
        $allData = array();
        $item = array();
        $location = array();
        $deptname = array();
        $joblist = array();
        foreach ($data as $key => $value) {
            foreach ($value as $cvalue) {
                if (isset($cvalue['JobOpenings'])) {
                    foreach ($cvalue['JobOpenings']['row'] as $finalVal => $val) {
                        foreach ($val['FL'] as $valkey => $sval) {
                            //print_r($valkey);
                            if (array_search("City", $sval)) {
                                $location[] = $sval['content'];
                            }
                            if (array_search("Department Name", $sval)) {
                                $deptname[] = $sval['content'];
                            }

                            $item[$sval['val']] = $sval['content'];
                        }
                        $allData[] = $item;
                    }
                }
            }
        }
        //         echo'<pre>'; print_r($allData);die();
        foreach ($allData as $key => $value) :
            if ($request->city_name != '' || $request->position_name != '') :
                if ($value['City'] == $request->city_name || $value['Department Name'] == $request->position_name) :
                    $list['job_tile'] = $value['Posting Title'];
                    $list['department'] = $value['Department Name'];
                    $list['addr'] = $value['City'] . ',' . $value['State'];
                    $joblist[] = $list;
                endif;
            else :
                $list['job_tile'] = $value['Posting Title'];
                $list['department'] = $value['Department Name'];
                $list['addr'] = $value['City'] . ',' . $value['State'];
                $joblist[] = $list;
            endif;



        endforeach;
        return json_encode(['code' => '200', 'data' => $joblist, 'location' => array_unique($location), 'deptname' => array_unique($deptname)]);


        exit;
    }

    public function getOurTeam()
    {
        $team = OurTeam::whereStatus(1)->get();

        $list = array();
        foreach ($team as $key => $value) :
            if ($value->type == 1) :
                $item['name'] = $value['name'];
                $item['designation'] = $value['designation'];
                $item['image'] = "https://d33umu47ssmut9.cloudfront.net/teamthumb/" . $value->image;
                $item['description'] = $value['descr'];
                $item['linkedin'] = $value['linkedin'];
                $item['twitter'] = $value['twitter'];
                $list['leadership'][] = $item;
            else :
                $item['name'] = $value['name'];
                $item['designation'] = $value['designation'];
                $item['image'] = "https://d33umu47ssmut9.cloudfront.net/teamthumb/" . $value->image;
                $item['description'] = $value['descr'];
                $item['linkedin'] = $value['linkedin'];
                $item['twitter'] = $value['twitter'];
                $list['team'][] = $item;
            endif;
        endforeach;
        return json_encode(['code' => '200', 'data' => $list]);
    }

    public function sendTourinfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'school' => 'required',
            'city'  => 'required',
            'contact' => 'required|numeric|min:10',
            'noofguest' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all(), 'code' => '500']);
        } else {

            switch ($request->city) {
                case 'Delhi':
                    $date = "10 December, 2019";
                    $address = "India habitat Centre, Delhi";
                    break;
                case 'Chandigarh':
                    $date = "13 December, 2019";
                    $address = "Taj Chandigarh, Chandigarh";
                    break;
                case 'Jaipur ':
                    $date = "18 December, 2019";
                    $address = "The Lalit, Jaipur";
                    break;
                case 'Hyderabad':
                    $date = "20 December, 2019";
                    $address = "Novotel Hyderabad Convention Centre, Hyderabad";
                    break;
                case 'Bhopal':
                    $date = "20 December, 2019";
                    $address = "Courtyard by Marriott, Bhopal";
                    break;
                case 'Banglore':
                    $date = "7 January, 2020";
                    $address = "Banglore";
                    break;
                case 'Mumbai':
                    $date = "9 January, 2020";
                    $address = "Mumbai";
                    break;
                case 'Ahmedabad':
                    $date = "13 January, 2020";
                    $address = "Ahmedabad";
                    break;
                case 'Chennai':
                    $date = "22 January, 2020";
                    $address = "Chennai";
                    break;
                case 'Kolkata':
                    $date = "22 January, 2020";
                    $address = "Kolkata";
                    break;

                default:
                    break;
            }

            $recipient = array('name' => $request->name, 'email' => $request->email, 'school' => $request->school, 'city' => $request->city, 'contact' => $request->contact, 'noofguest' => $request->noofguest,'date'=>$date,'address'=>$address);

            // Send this mail to Guest
            Mail::send('emails.citytourclient', $recipient, function ($message) use ($recipient) {
                $message->to($recipient['email'])->subject('GPTS - Future Readiness Summit');
                $message->from('no-reply@greatplacetostudy.com', 'Great Place To Study');
            });

            // Send this mail to GPTS Internal Team
            Mail::send('emails.citytourteam', $recipient, function ($message) use ($recipient) {
                $message->to("megha@greatplacetostudy.org")->subject('GPTS - Future Readiness Summit');
                $message->from('no-reply@greatplacetostudy.com', 'Great Place To Study');
                $message->bcc('learn@greatplacetostudy.org');
            });

            return json_encode(['code' => '200', 'msg' => 'Thank you registration with us.']);
        }
    }

    public function interviews(Request $request,$id=null){
        error_reporting(0);

        if($id){
            $interviews = \DB::select("SELECT type,career_id,name,title,designation,video_thumb,video,about FROM gpts_career_library_video WHERE career_id IN(SELECT id FROM gpts_career_library WHERE parent='$id')");
        }else{
            $interviews = \DB::select("SELECT type,career_id,name,title,designation,video_thumb,video,about FROM gpts_career_library_video WHERE career_id IN(SELECT id FROM gpts_career_library)");
        }

        $data=array();
        foreach($interviews AS $row){
            $dd['name']=$row->name;
            $dd['title']=$row->title;
            $dd['designation']=$row->designation;
            $dd['about']=$row->about;

            if($row->type=='1'){
                $dd['video_thumb']="https://d33umu47ssmut9.cloudfront.net/career-library/Expert/".$row->video_thumb;
                $dd['video']="https://d33umu47ssmut9.cloudfront.net/career-library/Expert/".$row->video;
            }else
            if($row->type=='2'){
                $dd['video_thumb']="https://d33umu47ssmut9.cloudfront.net/career-library/Intermediate/".$row->video_thumb;
                $dd['video']="https://d33umu47ssmut9.cloudfront.net/career-library/Intermediate/".$row->video;
            }else
            if($row->type=='3'){
                $dd['video_thumb']="https://d33umu47ssmut9.cloudfront.net/career-library/Beginner/".$row->video_thumb;
                $dd['video']="https://d33umu47ssmut9.cloudfront.net/career-library/Beginner/".$row->video;
            }

            $data[]=$dd;

        }
        return json_encode(['code' => '200', 'data' => $data],JSON_PRETTY_PRINT);
    }

    public function institutions(Request $request){
        $institutions = \DB::select("SELECT thumbnail,video FROM univ_details LIMIT 0,4");

        $query=TTECareer::select('gpts_tte_career_list.tte_career_id','gpts_tte_career_list.name','lib.cluster_image','lib.cluster_video','lib.video_thumb','lib.cluster_thumb','lib.edieo_cluster_thumb')->LeftJoin('gpts_career_library as lib','lib.tte_career_id','=','gpts_tte_career_list.tte_career_id');
        $query->whereIn('lib.id',array('9','25','10','19','13','15','16','7','5','28'));
        $query->limit(10);
        $clusters=$query->get();

        /*$data1=array();
        foreach($institutions As $row){

            $dd['cover']=(!empty($row->thumbnail))? "https://d33umu47ssmut9.cloudfront.net/institute/1/master_video/vertical/".$row->thumbnail:'';
            $dd['video']=(!empty($row->video))? "https://d33umu47ssmut9.cloudfront.net/institute/1/master_video/".$row->video:'';

            $data1[]=$dd;
        }
        */

        $list1 = array();
        foreach($clusters as $row){
          $item1['name']=$row->name;
          $item1['cover']=(!empty($row->edieo_cluster_thumb))?"https://gpts-portal.s3-eu-west-1.amazonaws.com/career/career-video/" . $row->edieo_cluster_thumb:'';
          $item1['video']=(!empty($row->cluster_video))?"https://d33umu47ssmut9.cloudfront.net/career/discover/" . $row->cluster_video:'';
          $item1['video_cover']=(!empty($row->cluster_thumb))?"https://d33umu47ssmut9.cloudfront.net/career/discover/" . $row->cluster_thumb:'';

          $datalist1[] = $item1;
        }

        //$result=array_merge($data1,$datalist1);

        return json_encode(['code' => '200', 'data' => $datalist1],JSON_PRETTY_PRINT);

    }

    public function universityList(Request $request,$id){
        $university = \DB::select("SELECT name,poster,thumbnail,video FROM gpts_university WHERE cluster_id='".$id."'");

        $list = array();
        foreach($university as $row){
          $item1['name']=$row->name;
          $item1['cover']=(!empty($row->poster))?"https://d33umu47ssmut9.cloudfront.net/university/" . $row->poster:'';
          $item1['thumbnail']=(!empty($row->thumbnail))?"https://d33umu47ssmut9.cloudfront.net/university/" . $row->thumbnail:'';
          $item1['video']=(!empty($row->video))?"https://d33umu47ssmut9.cloudfront.net/university/" . $row->video:'';

          $list[] = $item1;
        }

        return json_encode(['code' => '200','data' => $list],JSON_PRETTY_PRINT);
    }

    public function homevideos(Request $request){
        $videos = \DB::select("SELECT name,thumbnail,isbg,video,poster FROM gpts_home_videos");

        $list = array();
        $list1=array();
        foreach($videos as $row){

          $item1['name']=$row->name;
          $item1['cover']=(!empty($row->poster))?"https://d33umu47ssmut9.cloudfront.net/home-video/new/" . $row->poster:'';
          $item1['thumbnail']=(!empty($row->thumbnail))?"https://d33umu47ssmut9.cloudfront.net/home-video/new/" . $row->thumbnail:'';
          $item1['video']=(!empty($row->video))?"https://d33umu47ssmut9.cloudfront.net/home-video/new/" . $row->video:'';

          if($row->isbg==1){
              $list1[] = $item1;
          }else{
              $list[] = $item1;
          }
        }

        return json_encode(['code' => '200','data' => array('bg'=>$list1,'videos'=>$list)]);
    }

    public function registerSummerSchool(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email',
            'contact_no' => 'required|max:20',
            'course'=>'required'
        ]);

        if($validator->fails()){
            $errorAll = array();
            foreach ($validator->errors()->getMessages() as $key => $error) {
                array_push($errorAll, $error[0]);
            }

            return response()->json(['message' => $errorAll, 'status_code' => 400], 200);
        }else{

            \DB::table('summer_school')->insert([
                'first_name' => $request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'contact_no'=>$request->contact_no,
                'course'=>$request->course
            ]);

            return response()->json(['message' => 'Than you for registering with us. We will contact you soon.', 'status_code' => 200]);
        }
    }
}
