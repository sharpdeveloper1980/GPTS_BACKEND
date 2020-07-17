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
use Auth;
use Mail;

class SearchController extends Controller {

    use HasApiTokens,
        Notifiable;

    /*
      |--------------------------------------------------------------------------
      |  Basic search for students
      |--------------------------------------------------------------------------
      |
     */

    public function getStudents(Request $request) {
        
    }

    public function getZohoOpeningJobs() {


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
        $data = json_decode($result, TRUE);
       
        $found = array();
        foreach ($data as $key => $value) {
            foreach ($value as $cvalue) {
                if (isset($cvalue['JobOpenings'])) {
                    foreach ($cvalue['JobOpenings']['row'] as $finalVal) {
                        if (in_array("Department Name", $finalVal['FL'])) {
                            echo "Match found";
                            die();
                        } else {
                            echo "Match not found";
                            die();
                        }
                    }
                }
            }
        }
        echo '<pre>';
        print_r($found);
        die();
        exit;
    }

}
