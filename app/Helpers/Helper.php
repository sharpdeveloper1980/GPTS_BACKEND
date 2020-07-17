<?php

namespace App\Helpers;

Use DB;
use App\Menu;
use App\ProductImage;
use App\GroupUser;
use App\User;
use App\CollegeType;
use App\FacilitiesIcon;
use App\UserPermission;
use App\SchoolType;
use App\CareerLibaryVideo;
use Auth;
use Config;
use App\Career;
use App\Country;
use App\State;
use URL;

class Helper {

    //Admin Dynamic Image
//    public $usertype;
    public static function menu($userRole, $createdBy) {
        if (Auth::user()->usertype == 11) {
            $getPerMenu = UserPermission::whereUserType($userRole)->first();
        } else {
            $getPerMenu = UserPermission::whereUserType($userRole)->whereCreatedBy($createdBy)->first();
        }
        $menu = Menu::whereStatus(1)->whereParent(0)->whereIn('id', explode(",", $getPerMenu['menu']))->orderBy('position', 'ASC')->get();

        $menuAll = array();
        foreach ($menu as $keymenu) {
            $data['menu'] = $keymenu->menu;
            $data['id'] = $keymenu->id;
            $data['link'] = $keymenu->link;
            $data['icon'] = $keymenu->icon;
            $data['submenu'] = Menu::whereStatus(1)->whereParent($keymenu->id)->whereIn('id', explode(",", $getPerMenu['sub_menu']))->orderBy('position', 'ASC')->get();
            $menuAll[] = $data;
        }

        // echo '<pre>'; print_r($menuAll);die();
        return $menuAll;
    }

    public static function getPermission($userRole, $createdBy) {
        if (Auth::user()->usertype == 11) {
            $getPerMenu = UserPermission::whereUserType($userRole)->first();
        } else {
            $getPerMenu = UserPermission::whereUserType($userRole)->whereCreatedBy($createdBy)->first();
        }

        $menu = Menu::whereStatus(1)->whereParent(0)->whereIn('id', explode(",", $getPerMenu['menu']))->orderBy('position', 'ASC')->get();
        $menuLink = array();
        foreach ($menu as $keymenu) {

            if (isset($keymenu->link) && !empty($keymenu->link)) {
                array_push($menuLink, $keymenu->link);
            }

            $submenu = Menu::whereStatus(1)->whereParent($keymenu->id)->whereIn('id', explode(",", $getPerMenu['sub_menu']))->orderBy('position', 'ASC')->get();

            foreach ($submenu as $submenukey) {
                array_push($menuLink, $submenukey->link);
            }
        }
        return $menuLink;
    }

    //Product Image Helper
    public static function productImage($product_id) {

        $ProductImage = ProductImage::wherePid(['pid' => $product_id, 'status' => 1])->orderBy('id', 'ASC')->limit(1)->first();
        if (isset($ProductImage->thumb)) {
            return $ProductImage->thumb;
        } else {
            return '';
        }
    }

    //Product Discount
    public static function getDiscount($userID, $prod, $price) {

        $discountArray = array('discount_price' => 0, 'discount' => 0);
        if (isset($userID) && $userID > 0) {
            $getGroup = GroupUser::join('crimson_group', 'crimson_group.id', '=', 'crimson_group_user.group_id')->whereUserId($userID)->first();
            //print_r($getGroup->product);die();
            if ($getGroup != '') {
                $product = explode(',', $getGroup->product);
                if (in_array($prod, $product)) {
                    $discountArray = array('discount_price' => (($price * $getGroup->percentage) / 100), 'discount' => $getGroup->percentage);
                }
            }
        }

        return $discountArray;
    }

    public static function setOrderStatus($value) {

        switch ($value) {
            case 'Pending':
                return 1;
                break;
            case 'In Process':
                return 2;
                break;
            case 'Completed':
                return 3;
                break;
            case 'Cancelled':
                return 4;
                break;
            default:
                return 1;
                break;
        }
    }

    public static function getVideoType($type) {
        switch ($type):
            case 1:
                return 'Expert';
            case 2:
                return 'Intermediate';
            case 3:
                return 'Beginner';
        endswitch;
    }

    public static function getPerMenu($userRole, $createdBy) {
        if (Auth::user()->usertype == 11) {
            $getPerMenu = UserPermission::whereUserType($userRole)->first();
        } else {
            $getPerMenu = UserPermission::whereUserType($userRole)->whereCreatedBy($createdBy)->first();
        }
    }

    public static function getfacultyicons() {
        $icons = FacilitiesIcon::get();

        return $icons;
        return $getPerMenu;
    }

    public static function getCollageType() {
        $collagetype = CollegeType::get();
        $list = array();
        foreach ($collagetype as $key => $value) :
            $list[$value['id']] = $value['name'];

        endforeach;
        return $list;
    }

    public static function getSchoolType() {
        $schooltype = SchoolType::get();
        $list = array();
        foreach ($schooltype as $key => $value) :
            $list[$value['id']] = $value['name'];

        endforeach;
        return $list;
    }

    public static function getUniversity() {
        $unitype = User::whereUsertype(Config::get('constants.UniversityType'))->whereStatus(1)->orderByDesc('name')->get();
        $list = array();
        foreach ($unitype as $key => $value) :
            $list[$value['id']] = $value['name'];

        endforeach;
        $list[0] = 'Other';
        return $list;
    }

    public static function getCollege() {
        $unitype = User::whereUsertype(Config::get('constants.CollegeType'))->whereStatus(1)->orderByDesc('name')->get();
        $list = array();
        foreach ($unitype as $key => $value) :
            $list[$value['id']] = $value['name'];

        endforeach;

        return $list;
    }

    public static function getCareer() {
        $unitype = Career::whereStatus(1)->orderByDesc('name')->get();
        $list = array();
        foreach ($unitype as $key => $value) :
            $list[$value['id']] = $value['name'];

        endforeach;

        return $list;
    }

    public static function getParentCareer() {
        $unitype = Career::whereStatus(1)->whereParent(0)->orderByDesc('name')->get();
        $list = array();
        foreach ($unitype as $key => $value) :
            $list[$value['id']] = $value['name'];

        endforeach;

        return $list;
    }

    public static function getSubCareer($career_id) {
        $unitype = Career::whereStatus(1)->whereParent($career_id)->orderByDesc('name')->get();
        $list = array();
        foreach ($unitype as $key => $value) :
            $list[$value['id']] = $value['name'];

        endforeach;

        return $list;
    }

    // public static function getfacultyicons() {
    //     $icons = FacilitiesIcon::get();
    //     return $icons;
    // }
    //curl fuction for tte api

    public static function con($type = 'Post', $path, $post = array()) {
        $data = json_encode($post);
//echo json_encode($post);die();
//The URL of the resource that is protected by Basic HTTP Authentication.
        $url = $path;

//Your username.
        $username = '8dead0a1-f682-403f-b667-7636634ef19a';

//Your password.
        $password = 'edf6ac745d6452090389b9a5d48385aef9ee24ac60fa74ebcb8921fe18f01f3a';

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic OGRlYWQwYTEtZjY4Mi00MDNmLWI2NjctNzYzNjYzNGVmMTlhOmVkZjZhYzc0NWQ2NDUyMDkwMzg5YjlhNWQ0ODM4NWFlZjllZTI0YWM2MGZhNzRlYmNiODkyMWZlMThmMDFmM2E=');

//Initiate cURL.
        $ch = curl_init($url);

//Specify the username and password using the CURLOPT_USERPWD option.
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        if ($type == 'Post'):
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        endif;


//Set the headers that we want our cURL client to use.
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//Tell cURL to return the output as a string instead
//of dumping it to the browser.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Execute the cURL request.
        $response = curl_exec($ch);

//Check for errors.
        if (curl_errno($ch)) {
            //If an error occured, throw an Exception.
            throw new Exception(curl_error($ch));
        }

//Print out the response.
        return $response;
    }

    public static function getTteCareerId() {
        $list = array();

        for ($i = 91; $i <= 300; $i++) {
            $list[$i] = $i;
        }
        return $list;
    }

    public static function getCountry() {
        $country = Country::select('id', 'country_name')->where(['status' => 1])->orderBY('country_name', 'ASC')->get();
        $list = array();
        foreach ($country as $key => $value) :
            $list[$value['id']] = $value['country_name'];

        endforeach;

        return $list;
    }

    public static function getState() {
        $state = State::select('id', 'name')->orderBY('name', 'ASC')->get();
        $list = array();
        foreach ($state as $key => $value) :
            $list[$value['id']] = $value['name'];

        endforeach;

        return $list;
    }

    public static function getStateName($id) {
        $state = State::select('name')->whereId($id)->first();
        return $state['name'];
    }

    public static function getCountryName($id) {
        $country = Country::select('country_name')->whereId($id)->first();
        return $country['country_name'];
    }

    public static function checkCareerVideo($career_id) {
        $subcareer = Career::select('id')->whereParent($career_id)->whereStatus(1)->get();
         $careerids = array();
        if (!empty($subcareer)):
            foreach ($subcareer as $key => $value) :
                $careerids[] = $value->id;
            endforeach;
            $careervideo = CareerLibaryVideo::whereIn('career_id', $careerids)->whereType(1)->whereStatus(1)->count();
            if ($careervideo > 0):
                return 1;
            else:
                return 0;
            endif;
        else:
            return 0;
        endif;
    }


    public static function zoomAPI($url, $data = array()) {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiIyNmY0ZTM3OS0xZWM1LTQwYzMtODQ3Yi0yMjE3ZDJlMGY0NjUifQ.eyJ2ZXIiOiI2IiwiY2xpZW50SWQiOiJxR2RSWEVfRVJPYXFzV3Y2czVYX3pnIiwiY29kZSI6IkV2eHBVR3dOcHhfTFZGVE9WV0xUX21QNWx4Nl96bnFGUSIsImlzcyI6InVybjp6b29tOmNvbm5lY3Q6Y2xpZW50aWQ6cUdkUlhFX0VST2Fxc1d2NnM1WF96ZyIsImF1dGhlbnRpY2F0aW9uSWQiOiI2N2QyZGNmM2JjODE5ZmU2NmJmODY5ZDUzZDQ2Y2Q5YyIsInVzZXJJZCI6IkxWRlRPVldMVF9tUDVseDZfem5xRlEiLCJncm91cE51bWJlciI6MCwiYXVkIjoiaHR0cHM6Ly9vYXV0aC56b29tLnVzIiwiYWNjb3VudElkIjoidXhLUkd1bkpSMS1DZUJlUllnNHV2QSIsIm5iZiI6MTU4NjQxNDU3OCwiZXhwIjoxNTg2NDE4MTc4LCJ0b2tlblR5cGUiOiJhY2Nlc3NfdG9rZW4iLCJpYXQiOjE1ODY0MTQ1NzgsImp0aSI6IjViOTExZmU4LTg5NDYtNDAwZC05ZTM2LTkwYjkyNjQzZGM3OCIsInRvbGVyYW5jZUlkIjowfQ.mLobSEI0OxyNH6NTSVrcxhIsayQI5cljFbLzM0AuEXg2dvPUITdS0NnGgyTy3lli-kBr3yAlHXHnSJrgC5NeiQ",
            "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
