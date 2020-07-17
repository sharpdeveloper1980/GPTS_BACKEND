<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::group(['namespace' => 'Api'], function () {

    // Webinar
    Route::get('/zoom-access-token','WebinarController@response');
    Route::post('/zoom-register','WebinarController@callZoom');
    Route::post('/webinar-register','WebinarController@register');


	Route::post('/register-summer-sc','CommonController@registerSummerSchool');    

	// Institute List
	Route::get('/institute-list', 'InstituteController@getinstitutes')->name('institute-list');
    Route::get('/institute/{user_id}', 'InstituteController@getSingleInstitute');
    Route::get('/courses/{user_id}/{stream_id}', 'InstituteController@getCourses');
    Route::get('/streams/{user_id}', 'InstituteController@getStreams');
    Route::get('/suggested-institution/{user_id}', 'InstituteController@suggestedInst');
    
    // Notification API
    Route::post('/notify', 'NotifyController@notify')->name('notify');
    Route::post('/rcregister', 'NotifyController@rcregister')->name('rcregister');
    
    // Without Middleware Routes
    Route::post('/signup', 'UserController@signup')->name('signup');
    Route::post('/login', 'UserController@login')->name('login');
    Route::get('/country', 'CommonController@getCountry')->name('country');
    Route::post('/state', 'CommonController@getState')->name('state');
    Route::get('/college-type', 'CommonController@getCollegeType')->name('college-type');
    Route::get('/department', 'CommonController@getDepartment')->name('department');
    Route::get('/university', 'CommonController@getUniversity')->name('university');
    Route::get('/school', 'CommonController@getSchool')->name('school');
    Route::get('/collagestarrating', 'CommonController@getStarRating')->name('collagestarrating');
    Route::post('/forgot-password', 'UserController@forgotPassword')->name('forgot_password');
    Route::post('/college-profile', 'CollegeController@getCollegProfile')->name('college-profile');
    Route::post('/sendtourinfo', 'CommonController@sendTourinfo')->name('sendtourinfo');
    Route::post('/college-gallery', 'CollegeController@getGallery')->name('college-gallery');   

    //  home video
    Route::post('/getstaticpageVideo', 'CommonController@getHomeVideo')->name('getstaticpageVideo');
    Route::get('/gethomecollegeVideo', 'CommonController@getHomeCollegeVideo')->name('gethomecollegeVideo');
    Route::get('/gethomecareerVideo', 'CommonController@getHomeCareerVideo')->name('gethomecareerVideo');    Route::get('/getGLIVideo', 'CommonController@getGliVideo')->name('getGLIVideo');

    // Edieo
    Route::get('/getedieo', 'EdieoController@getEdieo')->name('getedieo');
    Route::post('/required-edieo', 'EdieoController@getEdieoOnRequired')->name('required-edieo');
    Route::get('/get-banner-video', 'EdieoController@getBannerVideo')->name('get-banner-video');  
    Route::post('/get-single-video', 'EdieoController@getSingleVideo')->name('get-single-video');
    Route::post('/my-fav', 'EdieoController@favVideo')->name('my-fav');  

  

    //Career
    Route::get('/getCareerList', 'CareerController@getCareerList')->name('getCareerList');
    Route::post('/CareerSearch', 'CareerController@CareerSearch');
    Route::post('/getSingleCareer', 'CareerController@getSingleCareer');
    Route::post('/getSingleSubCareer', 'CareerController@getSingleSubCareer');
    Route::post('/getCareerLibary', 'CareerController@getCareerLibaryList');
    Route::get('/insperationvideo', 'CareerController@insperationvideo')->name('insperationvideo');

    //contact
    Route::post('/saveContactDetail',   'CommonController@saveContactDetail');
    Route::post('/sendProductInfoMail', 'CommonController@sendProductInfoMail');
    
    //post
    Route::get('/blog', ['uses' => 'PostController@index']);
    Route::get('/getPopularBlog', ['uses' => 'PostController@getPopularBlog']);
    Route::get('/getLatestBlog', ['uses' => 'PostController@getLatestBlog']);
    Route::post('/singleBlog', ['uses' => 'PostController@getSinglePost']);
    Route::post('/getCareerLatestVideoList', ['uses' => 'CareerController@getCareerLatestVideoList']);
    //featured video
    Route::get('/getFeaturedVideo','CommonController@getFeaturedVideo');
    Route::post('/getZohoOpeningJobs', 'CommonController@getZohoOpeningJobs');
    Route::get('/getourteam', 'CommonController@getOurTeam');


    // Discover Colleges
    Route::get('/discover', 'DiscoverColleges@discover')->name('discover');
    Route::post('/getcluster', ['uses' => 'DiscoverColleges@getCluster']);
    // End
    
    /*Design College*/
    Route::get('/design-college', 'DesignCollege@design')->name('design-college');
    
    //Counsellor API
    Route::get('/students-list', 'CounsellorController@index');
    Route::get('/getpdfreport', 'CounsellorController@getreport');

    Route::get('/interviews/{id?}','CommonController@interviews');
    Route::get('/institutions','CommonController@institutions');

    Route::get('/homevideos','CommonController@homevideos');
    Route::get('/university-listing/{id}','CommonController@universityList');
        

    Route::middleware('auth:api')->group(function () {

        Route::post('/student-second-step', 'StudentController@studentSignUpSecondStep')->name('student-second-step');
        Route::post('/get-student-info', 'StudentController@getStudentInfo')->name('get-student-info');
        Route::post('/edit-student-personal-info', 'StudentController@editStudentPerInfo')->name('edit-student-personal-info');
        Route::post('/edit-student-family-info', 'StudentController@editStudentFamInfo')->name('edit-student-family-info');
        Route::post('/edit-student-education-info', 'StudentController@editStudentEducationInfo')->name('edit-student-education-info');
        Route::get('/get-student-list', 'StudentController@getStudentList')->name('get-student-list');
        Route::post('/upload-profile-pic', 'UserController@updateProfilePic')->name('upload-profile-pic');

        // SOP
        Route::post('/default-text-sop', 'CommonController@getDefaultTextSop')->name('default-text-sop');
        Route::post('/default-video-sop', 'CommonController@getDefaultVideoSop')->name('default-video-sop');
        Route::post('/get-student-text-sop', 'StudentController@getStudentTextSop')->name('get-student-text-sop');
        Route::post('/sop-text-answer', 'StudentController@sopTextAnswer')->name('sop-text-answer');
        Route::post('/sop-video-answer', 'StudentController@sopVideoAnswer')->name('sop-video-answer');
        Route::post('/get-student-sop', 'StudentController@getStudentSop')->name('get-student-sop');

        // Collage Redirection
        Route::post('/college-registration', 'CollegeController@collegeRegistration')->name('college-registration');
        Route::post('/university-registration', 'CollegeController@universityRegistration')->name('university-registration');
        Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');
        Route::post('/update-objective', 'StudentController@setObjetive')->name('update-objective');
        Route::post('/show-objective', 'StudentController@getObjective')->name('show-objective');
        Route::post('/set-activity', 'StudentController@setActivity')->name('set-activity');
        Route::post('/get-activity', 'StudentController@getActivity')->name('get-activity');
        Route::get('/logout', 'UserController@logout')->name('logout');

        //Tte
        Route::post('/tteCreateUser', 'TteController@saveTteUser')->name('tteCreateUser');
        Route::post('/authSso', 'TteController@authSso')->name('authSso');
        Route::post('/tteUserReport', 'TteController@getReport')->name('tteUserReport');
        Route::post('/tteUserStatus', 'TteController@tteUserStatus')->name('tteUserStatus');
        Route::post('/getReportPdf', 'TteController@getReportPdf')->name('getReportPdf');

        //CareerVideo
        Route::get('/getFacilitiesList', 'CollegeController@getfacilities')->name('getFacilitiesList');
        Route::post('/getSearchCareerVideo', 'CareerController@searchCareerVideo')->name('getSearchCareerVideo');
        Route::post('/getRecommendedVideo', 'CareerController@getRecommendedVideo')->name('getRecommendedVideo');
        //Career Video Wishlist
        Route::post('/addToMyFavorite', 'CareerController@addToMyFavorite')->name('addToMyFavorite');
        Route::post('/getAllMyFav', 'CareerController@getAllMyFav')->name('getAllMyFav');

        //Career
        Route::post('/savepreviousvideo', 'CareerController@SavePreviousVideo');
        Route::post('/ttecareervideolist', 'CareerController@recommendedVideolist');
        Route::post('/previousVideolist', 'CareerController@previousVideolist');

        //change password
        Route::post('/changePassword', 'UserController@changePassword');
            
    });
});
