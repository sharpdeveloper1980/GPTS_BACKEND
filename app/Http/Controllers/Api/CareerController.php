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
use App\CareerLibaryVideo;
use Carbon\Carbon;
use App\Setting;
use App\CareerExam;
use App\TteUsers;
use App\CollegeGallery;
use App\InspiringVideo;
use App\PreviousCareer;
use App\Helpers\Helper;
use App\Career;
use App\MyFav;
use App\EdieoFav;
use Auth;
use Mail;
use Config;
use URL;
use DB;

class CareerController extends Controller {

    use HasApiTokens,
        Notifiable;

    public function getCareerList() {
        $careerlist = Career::whereStatus(1)->whereParent(0)->get();
        $allData=array();
        foreach ($careerlist as $key => $value) :
                $item['career_id'] = $value['id'];
                $item['name'] = $value['name'];
                $item['slug'] = $value['slug'];
                $item['edieo_thumb'] = $value['edieo_thumb'] != null ? Config::get('constants.AWSURL').'/career/career-video/' . $value['edieo_thumb'] : 'https://via.placeholder.com/200';
                
                $item['career_icon'] = $value['career_icon'] != null ? Config::get('constants.AWSURL').'/career/career-icon/' . $value['career_icon'] : 'https://via.placeholder.com/200';
                $item['career_banner'] = $value['career_banner'] != null ? Config::get('constants.AWSURL').'/career/career-banner/' . $value['career_banner'] : 'https://via.placeholder.com/1400x500';
                $item['career_thumb'] = $value['career_thumb'] != null ? Config::get('constants.AWSURL').'/career/career-thumb/' . $value['career_thumb'] : 'https://via.placeholder.com/300';
                $allData[] = $item;               
            endforeach;
        return response()->json(['code' => '200', 'data' => $allData]);
    }

    /*

     * career video search 
     * @param int career_id 
     * @param int user_id 
     */

    public function searchCareerVideo(Request $request) {
        $validator = Validator::make($request->all(), [
                    'career_id' => 'required',
                    'user_id' => 'required',
                    
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {
            try {

                if ($request->career_id != 0):
                    $career = Career::whereId($request->career_id)->whereStatus(1)->first();
                else:
                    $career = 1;
                endif;
                $subcareerlist = array();
                $careerids = array();
                if ($career != ''):
                    $query = Career::select('id', 'name', 'slug', 'career_icon', 'career_banner');
                    if ($request->career_id != 0):
                        $query->whereParent($career->id);
                    else:
                        $query->where('parent', '!=', 0);
                    endif;
                    $subcareer = $query->whereStatus(1)->get();

                    if (!empty($subcareer)):
                        $type = 0;
                        if(isset($request->type) && $request->type!=''):
                            $type=1;
                            else:
                            $type=0;
                        endif;
                        if($type==1):
                            $videocareerids = array();
                            foreach ($subcareer as $key => $value) :
                            $videocareerids[] = $value->id;                           
                        endforeach;
                        $subcareerlist['subcareer_video'] = $this->getSubCareerVideo($videocareerids, $request->user_id,$type);
                            else:
                           foreach ($subcareer as $key => $value) :
                            $item['sub_career_name'] = $value->name;
                            $item['sub_career_slug'] = $value->slug;
                            $item['sub_career_icon'] = $value->career_icon!=''?Config::get('constants.AWSURL')."/career/career-icon/" . $value->career_icon:url('/public/image/defaultsubcareer.png');
                            $item['sub_career_banner'] = Config::get('constants.AWSURL')."/career/career-banner/" . $value->career_banner;
                            $item['subcareer_video'] = $this->getSubCareerVideo($value->id, $request->user_id,$type);
                            $subcareerlist[] = $item;
                        endforeach; 
                        endif;
                        
                    endif;
                endif;
                $total = count($subcareerlist['subcareer_video']);
                if(count($subcareerlist['subcareer_video'])>0){
                    return response()->json(['code' => '200', 'data' => $subcareerlist, 'msg' => 'Video found', 'total' => $total]);
                }else{
                    return response()->json(['code' => '200', 'data' => array(), 'msg' => 'We will shortly upload the video in this career domain', 'total' => 0]);
                }
                
                
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    public function getSubCareerVideo($careerid, $user_id,$type) {
        $query = CareerLibaryVideo::select('id', 'name','designation','about' ,'title', 'video', 'type', 'video_thumb');
        if (isset($careerid) && $careerid != '' && $careerid != 0 && $type==0) {
            $query->where('career_id', $careerid);
        }else{
            $query->whereIn('career_id', $careerid);
        }

        $searchList = $query->whereStatus(1)->get();
        $allData = array();
        foreach ($searchList as $key => $careerVideo) {
            $item['title'] = $careerVideo->title;
            $item['name'] = $careerVideo->name;
            $item['designation'] = $careerVideo->designation;
            $item['video_id'] = $careerVideo->id;
            $item['type'] = Helper::getVideoType($careerVideo->type);
            $item['video_thumb'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($careerVideo->type) . "/" . $careerVideo->video_thumb;
            $item['video'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($careerVideo->type) . "/" . $careerVideo->video;
            $item['fav'] = $this->checkVideoInFav($user_id, $careerVideo->id);
            $allData[] = $item;
        }
        return $allData;
    }

    /*

     * search career
     * @param int id    
     */
    
    /*

     * Get expert Video    
     */
        public function getExpCareerVideo($careerid, $user_id) {
        $allData = array();
            $query = CareerLibaryVideo::select('id', 'name','designation', 'title', 'video', 'type', 'video_thumb');
        if (isset($careerid) && $careerid != '' && $careerid != 0) {
            $query->where('career_id', $careerid);
        }
        $careerVideo = $query->whereType(1)->whereStatus(1)->first();
        if($careerVideo!=''):
           $allData['title'] = $careerVideo->title;
            $allData['name'] = $careerVideo->name;
            $allData['designation'] = $careerVideo->designation;
            $allData['video_id'] = $careerVideo->id;
            $allData['type'] = Helper::getVideoType($careerVideo->type);
            $allData['video_thumb'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($careerVideo->type) . "/" . $careerVideo->video_thumb;
            $allData['video'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($careerVideo->type) . "/" . $careerVideo->video;
            $allData['fav'] = $this->checkVideoInFav($user_id, $careerVideo->id);
             
        endif;
           
        return $allData;
    }

    public function CareerSearch(Request $request) {
        $validator = Validator::make($request->all(), [
                    'career_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {
            try {
                $query = Career::whereStatus(1);
                if (isset($request->career_id) && $request->career_id != '' && $request->career_id != 0) {
                    $query->where('id', $request->career_id);
                }
                $searchList = $query->get();
                return response()->json(['code' => '200', 'data' => $searchList]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    // Add and Delete from My Fav
    public function addToMyFavorite(Request $request) {

        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'career_video_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {
            try {
                if ($request->type == 'add') {

                    $addToFav = new MyFav();
                    $addToFav->user_id = $request->user_id;
                    $addToFav->career_video = $request->career_video_id;
                    $addToFav->created_at = date('Y-m-d');
                    $addToFav->save();
                    return response()->json(['code' => '200', 'msg' => 'Added to wishlist!']);

                } else if ($request->type == 'delete' || $request->vtype == 'edieo') {
                    
                    if($request->type == 'delete' && $request->vtype != 'edieo'){
                       $deleteMyFav = MyFav::whereUserId($request->user_id)->whereCareerVideo($request->career_video_id)->delete();
                    }else{
                        $deleteMyFav = EdieoFav::whereUserId($request->user_id)->whereVideo($request->career_video_id)->delete();
                    }
                    
                    return response()->json(['code' => '200', 'msg' => 'Deleted from wishlist!']);
                }
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    // Get All My Fav
    public function getAllMyFav(Request $request) {

        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {
            try {
                $user_id = $request->user_id;
                $favvideo = CareerLibaryVideo::with('faVideo')
                                ->whereHas('faVideo', function($query) use ($user_id) {
                                    $query->whereUserId($user_id);
                                })->whereStatus(1)->get();
                //print_r($favvideo);
                $allData = array();
                foreach ($favvideo as $key => $careerVideo) {
                    $item['title'] = $careerVideo->title;
                    $item['name'] = $careerVideo->name;
                    $item['designation'] = $careerVideo->designation;
                    $item['video_id'] = $careerVideo->id;
                    $item['type'] = Helper::getVideoType($careerVideo->type);
                    $item['video_thumb'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($careerVideo->type) . "/" . $careerVideo->video_thumb;
                    $item['video'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($careerVideo->type) . "/" . $careerVideo->video;
                    $allData[] = $item;
                }

                $fav = EdieoFav::select('gpts_edieo.*')->join('gpts_edieo','gpts_edieo.id','=','gpts_edieo_fav.video')->whereUserId($request->user_id)->get();
                foreach ($fav as $key => $edieoFav) {
                    $item['title'] = $edieoFav->title;
                    $item['name'] = '';
                    $item['designation'] = $edieoFav->descp;
                    $item['video_id'] = $edieoFav->id;
                    $item['type'] = 'edieo';
                    $item['video_thumb'] = Config::get('constants.AWSURL')."/edieo/thumb/". $edieoFav->video_thumb;
                    $item['video'] = Config::get('constants.AWSURL')."/edieo/video/" . $edieoFav->video;
                    $allData[] = $item;
                }

                return response()->json(['code' => '200', 'data' => $allData]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    /*

     * Get single parent career
     * @param string slug
     *     
     */

    public function getSingleCareer(Request $request) {
        error_reporting(0);

        $validator = Validator::make($request->all(), [
                    'slug' => 'required',
              
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {
            try {
                $career = Career::whereSlug($request->slug)->whereStatus(1)->first();
                $subcareer = Career::select('id', 'name', 'slug','banner_title','career_icon', 'career_banner','career_image')->whereParent($career->id)->whereStatus(1)->get();
                $subcareerlist = array();
                $careerids = array();
                $subcareervideolist = array();
                if (!empty($subcareer)):
                    foreach ($subcareer as $value):
                        $careerids[] = $value->id;
                        $item['sub_career_id']=$value->id;
                        $item['sub_career_name'] = $value->name;
                        $item['sub_career_slug'] = $value->slug;
                        $item['sub_career_icon'] = $value->career_icon!=''?Config::get('constants.AWSURL')."/career/career-icon/" . $value->career_icon:url('/public/image/defaultsubcareer.png');
                        $item['sub_career_image'] = $value->career_image!=''?Config::get('constants.AWSURL')."/career/career-icon/" . $value->career_image:url('/public/image/no-image.jpg');
                        
                        if($value->slug){
                            $query=DB::select("SELECT cluster_image FROM gpts_edieo WHERE slug='".$value->slug."'");
                            $item['sub_cluster_image']=$query[0]->cluster_image!=''?Config::get('constants.AWSURL')."/edieo/thumb/" . $query[0]->cluster_image:'';
                        }else{
                            $item['sub_cluster_image']='';
                        }


//                        $item['sub_career_banner'] = Config::get('constants.AWSURL')."/career/career-banner/" . $value->career_banner;
                        $subcareerlist[] = $item;
                    endforeach;

                    $careervideo = CareerLibaryVideo::select('title', 'designation','name', 'video_thumb', 'video','id')->whereIn('career_id', $careerids)->whereType(1)->whereStatus(1)->get();

                    foreach ($careervideo as $value):
                        $videoitem['video_id'] = $value->id;
                        $videoitem['video_title'] = $value->title;
                        $videoitem['video_name'] = $value->name;
                        $videoitem['designation'] = $value->designation;
                        $videoitem['video_thumb'] = Config::get('constants.AWSURL')."/career-library/Expert/" . $value->video_thumb;
                        $videoitem['video'] = Config::get('constants.AWSURL')."/career-library/Expert/" . $value->video;
                       if(isset($request->user_id) && $request->user_id!=0 && $request->user_id!=''){
                         $videoitem['fav'] = $this->checkVideoInFav($request->user_id, $value->id);   
                       }
                        $subcareervideolist[] = $videoitem;
                    endforeach;
                endif;

                $allData = array();
                
                $allData['career_id'] = $career->id;
                $allData['name'] = $career->name;
                $allData['slug'] = $career->slug;
                $allData['banner_title'] = $career->banner_title;
                $allData['tte_career_id'] = $career->tte_career_id;
                $allData['about'] = $career->about;
                $allData['do_you_know'] = $career->do_you_know;
                $allData['career_icon'] = Config::get('constants.AWSURL')."/career/career-icon/" . $career->career_icon;
                $allData['career_banner'] = Config::get('constants.AWSURL')."/career/career-banner/" . $career->career_banner;
                $allData['exp_video'] = $career->exp_video!=''?Config::get('constants.AWSURL')."/career/career-video/" . $career->exp_video:'';
                $allData['exp_video_thumb'] = $career->video_thumb!=''?Config::get('constants.AWSURL')."/career/career-video/" . $career->video_thumb:'';
                $allData['exp_video_name'] = $career->video_title;
                $allData['exp_video_designation'] = $career->video_designation;
                $allData['sub_career_list'] = $subcareerlist;
                $allData['career_video'] = $subcareervideolist;
                

                return response()->json(['code' => '200', 'data' => $allData]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    /*

     * get single subcareer
     *  @param string slug 
     */

    public function getSingleSubCareer(Request $request) {

        $validator = Validator::make($request->all(), [
                    'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {
            try {
                $subcareervideolist = array();
                $subcareerexamlist = array();
                $allData = array();
                $career = Career::whereSlug($request->slug)->whereStatus(1)->first();

                if ($career != ''):
                    
                    $careervideo = CareerLibaryVideo::where('career_id', $career->id)->get();

                    if (!empty($careervideo)):
                        foreach ($careervideo as $value):
                        $videoitem['video_id'] = $value->id;
                        $videoitem['video_title'] = $value->title;
                        $videoitem['video_name'] = $value->name;
                        $videoitem['designation'] = $value->designation;
                        $videoitem['video_id'] = $value->id;
                        $videoitem['type'] = Helper::getVideoType($value->type);
                        $videoitem['video_thumb'] = $value->video_thumb != null ? Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($value->type) . "/" . $value->video_thumb : 'https://via.placeholder.com/1200x400';
                        $videoitem['video'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($value->type) . "/" . $value->video;
                           if(isset($request->user_id) && $request->user_id!=0 && $request->user_id!='' ){
                         $videoitem['fav'] = $this->checkVideoInFav($request->user_id, $value->id);   
                       }
                            $subcareervideolist[] = $videoitem;
                        endforeach;
                    endif;
                    $careerExam = CareerExam::where('career_id', $career->id)->get();
                    if (!empty($careerExam)):
                        foreach ($careerExam as $value):
                            $examitem['exam_name'] = $value->name;
                            $examitem['exam_detail'] = $value['details']!=''?$value->details:$this->defaultText();
                            $examitem['exam_date'] = $value['exam_date']!=''?date('d F Y', strtotime($value->exam_date)):$this->defaultText();
                            $examitem['application_form'] = $value['application_form']!=''?URL::to('/').'/public/image/career_exam/document/'.$value->application_form:$this->defaultText();
                            $examitem['application_fee'] = $value['application_fee']!=''?$value->application_fee:$this->defaultText();
                            $subcareerexamlist[] = $examitem;
                        endforeach;
                    endif;

                    $jobs=array();
                    
                    if(@$career->career_jobs){
                        foreach (@$career->career_jobs as $key => $value) :
                            $item['title'] = $value->title;
                            $item['description'] = strip_tags($value->description);
                            $jobs[] = $item;
                        endforeach;
                    }

                    $allData['career_id'] = $career->id;
                    $allData['name'] = $career->name;
                    $allData['slug'] = $career->slug;
                    $allData['about'] = $career->about;
                    $allData['area_cover'] = ($career->area_cover!=''? array_filter($career->area_cover) :'');
                    $allData['key_psychology'] = $career->key_psychology;
                    $allData['related_career'] = $career->related_career;
                    $allData['future_prospect'] = $career->prospect;
                    $allData['career_jobs'] = $jobs;
                    $allData['competencies'] = ($career->competencies!=''? array_filter($career->competencies) :'');
                    $allData['career_ladder'] = ($career->career_ladder!=''? array_filter($career->career_ladder, 'strlen') :'');
                    $allData['salary'] = $career->salary;
                    $allData['pros'] = $career->pros;
                    $allData['cons'] = $career->cons;
                    $allData['banner_title'] = $career->banner_title;
                    $allData['career_icon'] = Config::get('constants.AWSURL')."/career/career-icon/" . $career->career_icon;
                    $allData['career_banner'] = Config::get('constants.AWSURL')."/career/career-banner/" . $career->career_banner;
                    $allData['career_video'] = $subcareervideolist;
                    $allData['career_entrance_exam'] = $subcareerexamlist;
                 
                endif;


                return response()->json(['code' => '200', 'data' => $allData]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    //Check wish list video
    public function checkVideoInFav($user_id, $career_video) {
        $count = MyFav::whereUserId($user_id)->whereCareerVideo($career_video)->count();
        return $count;
    }

    /*

     * career libary list     

     */

    public function getCareerLibaryList(Request $request) {

        try {
            $allData = array();
            $query = Career::select('id', 'exp_video', 'name', 'about', 'slug', 'career_icon', 'career_banner','career_thumb')->whereParent(0);
            if (isset($request->career_name) && $request->career_name != ''):
                $query = $query->whereName($request->career_name);
            endif;
                $career = $query->whereStatus(1)->get();


            $latestcareervideo = CareerLibaryVideo::select('title','designation', 'name', 'video_thumb', 'video', 'about','id')->wherePriorityVideo(1)->orderByDesc('created_at')->first();
            $latestvideo = array();
            if ($latestcareervideo != null || $latestcareervideo != '') {
                $latestvideo['title'] = $latestcareervideo['title'];
                $latestvideo['name'] = $latestcareervideo['name'];
                $latestvideo['about'] = $latestcareervideo['about'];
                $latestvideo['designation'] = $latestcareervideo['designation'];
                $latestvideo['video_thumb'] = $latestcareervideo['video_thumb'] != '' ? Config::get('constants.AWSURL')."/career-library/Expert/" . $latestcareervideo->video_thumb : 'https://via.placeholder.com/1400x500';
                $latestvideo['video'] = $latestcareervideo['video'] != '' ? Config::get('constants.AWSURL')."/career-library/Expert/" . $latestcareervideo->video : '';
               if(isset($request->user_id) && $request->user_id!=0 && $request->user_id!=''){
                $latestvideo['fav'] = $this->checkVideoInFav($request->user_id, $latestcareervideo->id); 
               }
            } else {
                $latestvideo['title'] = '';
                $latestvideo['name'] = '';
                $latestvideo['about'] = '';
                $latestvideo['designation'] = '';
                $latestvideo['video_thumb'] = 'https://via.placeholder.com/1400x500';
                $latestvideo['video'] = '';
            }


            // $careervideolist = array();
            // http://34.248.49.86/api/getCareerLibary;
            $allData['latestcareervideo'] = $latestvideo;
            foreach ($career as $key => $value) :
                if(Helper::checkCareerVideo($value['id'])):
                $item['career_id']          = $value['id'];
                $item['career_name']        = $value['name'];
                $item['career_slug']        = $value['slug'];
                $item['career_icon']        = $value['career_icon'] != null ? Config::get('constants.AWSURL').'/career/career-icon/' . $value['career_icon'] : 'https://via.placeholder.com/200';
                $item['career_banner']      = $value['career_banner'] != null ? Config::get('constants.AWSURL').'/career/career-banner/' . $value['career_banner'] : 'https://via.placeholder.com/1400x500';
                $item['career_thumb']       = $value['career_thumb'] != null ? Config::get('constants.AWSURL').'/career/career-thumb/' . $value['career_thumb'] : 'https://via.placeholder.com/300';
                $item['video']              = Config::get('constants.AWSURL')."/career/career-video/" . $value['exp_video'];
                $item['descp']              = substr($value['about'], 0, 250);
                $item['subcareer']          = $this->subcareer($value['id'], $value['slug']);
                $allData['careerlist'][]    = $item;
                endif;
               
            endforeach;
            
            // sub Career
            foreach ($career as $key => $value) :
                if(Helper::checkCareerVideo($value['id'])):
                    $itemvideo['career_id'] = $value['id'];
                    $itemvideo['career_name'] = $value['name'];
                    $itemvideo['slug'] = $value['slug'];
                    $itemvideo['videolist'] = $this->getcareervideo($value['id'],$request->user_id);
                    $allData['careervideolist'][] = $itemvideo;
                endif;
            endforeach;
            return response()->json(['code' => '200', 'data' => $allData]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }
   
    // Get sub career
    public function subcareer($career_id, $slug){
        $subcareer = Career::select('name', 'slug')->whereParent($career_id)->whereStatus(1)->get();
        $subcareervideolist = array();
        if (!empty($subcareer)):
            foreach ($subcareer as $value) :
                $career['name']         = $value->name;
                $career['url']          = URL::to('/').'/course/'.$slug.'/'.$value['slug'];
                $subcareervideolist[]   = $career;
            endforeach;
        endif;
        return $subcareervideolist;
    }
    
    // Sub career video list
    public function getcareervideo($career_id,$user_id) {
        $subcareer = Career::select('id')->whereParent($career_id)->whereStatus(1)->get();
        $careerids = array();
        $subcareervideolist = array();
        if (!empty($subcareer)):
            foreach ($subcareer as $key => $value) :
                $careerids[] = $value->id;
            endforeach;
            $careervideo = CareerLibaryVideo::select('id','title', 'designation','name', 'video_thumb', 'video')->whereIn('career_id', $careerids)->whereType(1)->whereStatus(1)->get();

            foreach ($careervideo as $value):
                $videoitem['video_title'] = $value->title;
                $videoitem['video_name'] = $value->name;
                $videoitem['video_id'] = $value->id;
                $videoitem['designation'] = $value->designation;
                $videoitem['video_thumb'] = Config::get('constants.AWSURL')."/career-library/Expert/" . $value->video_thumb;
                $videoitem['video'] = Config::get('constants.AWSURL')."/career-library/Expert/" . $value->video;
               if(isset($user_id) && $user_id!=0 && $user_id!=''){
                $videoitem['fav'] = $this->checkVideoInFav($user_id, $value->id); 
               }
                $subcareervideolist[] = $videoitem;
            endforeach;
        endif;
        return $subcareervideolist;
    }

    /*

     * save previous user video   
     * @param int user_id
     * @param int video_id
     */

    public function SavePreviousVideo(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'video_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {
            try {
                $check = PreviousCareer::whereUser_id($request->user_id)->whereVideo_id($request->video_id)->first();
                if ($check == ''):
                    $previous = new PreviousCareer();
                    $previous->user_id = $request->user_id;
                    $previous->video_id = $request->video_id;
                    $previous->created_at = date('Y-m-d h:i:s');
                    $previous->save();
                    return response()->json(['code' => '200', 'msg' => 'Successfully Added']);
                endif;
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    public function getCareerVideolist($videoid,$user_id) {
//            print_r($videoid);die();
        $query = CareerLibaryVideo::select('id', 'name','designation', 'title', 'video', 'type', 'video_thumb');

        $query->whereIn('id', $videoid);

        $searchList = $query->whereStatus(1)->get();
        $allData = array();
        foreach ($searchList as $key => $careerVideo) {
            $item['title'] = $careerVideo->title;
            $item['name'] = $careerVideo->name;
            $item['designation'] = $careerVideo->designation;
            $item['video_id'] = $careerVideo->id;
            $item['type'] = Helper::getVideoType($careerVideo->type);
            $item['video_thumb'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($careerVideo->type) . "/" . $careerVideo->video_thumb;
            $item['video'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($careerVideo->type) . "/" . $careerVideo->video;
           if(isset($user_id) && $user_id!=0 && $user_id!=''){
            $item['fav'] = $this->checkVideoInFav($user_id, $careerVideo->id); 
             }
            $allData[] = $item;
        }
        return $allData;
    }

    //recommended video list
    public function recommendedVideolist(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {
            try {
                $recommendedvideo = array();
                if (isset($request->user_id) && $request->user_id != ''):
                    $tteuser = TteUsers::select('ranked_occupations')->whereStudent_id($request->user_id)->whereStatus(3)->first();
//            $ttecareerids =array();
                
                    if ($tteuser != ''):
                        $ranked_occupations = json_decode($tteuser->ranked_occupations);
                        foreach ($ranked_occupations as $value):
                            $ttecareerids[] = $value->id;
                        endforeach;

                        $career = Career::select('id')->whereIn('tte_career_id', $ttecareerids)->whereStatus(1)->get();
                        if (!$career->isEmpty()):
                            foreach ($career as $value):
                                $careerids[] = $value->id;
                            endforeach;
                            $subcareer = Career::select('id')->whereIn('parent', $careerids)->whereStatus(1)->get();
                          
                            if (!$subcareer->isEmpty()):
                                foreach ($subcareer as $key => $value) :
//                                    $video['id'] = $value->id;
                                    $video= $this->getExpCareerVideo($value->id, $request->user_id);
                                if(!empty($video)):
                                     $recommendedvideo[] = $video;
                                endif;
                                   
                                endforeach;
                            endif;
                        endif;
                    endif;
                endif;
                return response()->json(['code' => '200', 'data' => $recommendedvideo]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    public function insperationvideo() {
        $inspiringvideo = InspiringVideo::whereStatus(1)->where('position', '>', '0')->orderBy('position', 'ASC')->get();
        $allData = array();
        foreach ($inspiringvideo as $key => $value) :
            $list['video_title'] = $value['title'];
            $list['video_name'] = $value['name'];
            $list['video_id'] = $value->id;
            $list['designation'] = $value['designation'];
            $list['video_thumb'] = Config::get('constants.AWSURL')."/inspiring/image/" . $value['video_thumb'];
            $list['video'] = Config::get('constants.AWSURL')."/inspiring/video/" . $value['video'];
            $allData['inspiringvideo'][] = $list;
        endforeach;
        return response()->json(['code' => '200', 'data' => $allData]);
    }

    public function previousVideolist(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
        } else {
            try {
                $previouslist = array();
                if (isset($request->user_id) && $request->user_id != ''):
                    $previousVideo = PreviousCareer::select('video_id')->whereUser_id($request->user_id)->orderByDesc('created_at')->get();
                    if (!$previousVideo->isEmpty()):
                        foreach ($previousVideo as $value):
                            $videoids[] = $value->video_id;
                        endforeach;
                        $previouslist = $this->getCareerVideolist($videoids,$request->user_id);
                    else:
                        $previouslist = array();
                    endif;
                else:
                    $previouslist = array();
                endif;
                return response()->json(['code' => '200', 'data' => $previouslist]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }
    
    public function defaultText() {
        return 'TBA';
    }
    
    public function getCareerLatestVideoList(Request $request) {
          $query = CareerLibaryVideo::select('id', 'name','designation', 'title', 'video', 'type', 'video_thumb','about')->orderByDesc('created_at')->take(6)->get();
           $allData = array();
        foreach ($query as $key => $careerVideo) {
            if($careerVideo->video_thumb!=null && $careerVideo->video!=null):

            $item['title'] = $careerVideo->title;
            $item['video_name'] = $careerVideo->name;
            $item['designation'] = $careerVideo->designation;
            $item['video_id'] = $careerVideo->id;
            $item['type'] = Helper::getVideoType($careerVideo->type);
            $item['video_thumb'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($careerVideo->type) . "/" . $careerVideo->video_thumb;
            $item['video'] = Config::get('constants.AWSURL')."/career-library/" . Helper::getVideoType($careerVideo->type) . "/" . $careerVideo->video;
           if(isset($request->user_id) && $request->user_id!=0 && $request->user_id!=''){
            $item['fav'] = $this->checkVideoInFav($request->user_id, $careerVideo->id); 
             }
            $allData[] = $item;
                            
            endif;
        }
        return response()->json(['code' => '200', 'data' => $allData]);
    }

}
