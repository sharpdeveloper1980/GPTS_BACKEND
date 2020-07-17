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
use App\CollegeGallery;
use App\Helpers\Helper;
use App\Career;
use App\MyFav;
use Auth;
use Mail;

class CareerTestController extends Controller {

    use HasApiTokens,
        Notifiable;


   

}
