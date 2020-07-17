<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */


Route::group(['namespace' => 'Admin'], function () {



    Route::group(['middleware' => ['web']], function () {
        Route::get('administrator', ['as' => 'login', 'uses' => 'LoginController@index']);
        Route::post('administrator', ['as' => 'user.auth', 'uses' => 'LoginController@userAuth']);
        Route::get('admin/forgot-password', ['as' => 'user.auth', 'uses' => 'LoginController@forgotPassword']);
        Route::post('admin/sendToken', array('uses' => 'LoginController@sendResetPasswordToken'));
        Route::get('admin/reset-password/{token}', array('uses' => 'LoginController@resetPassword'));
        Route::post('admin/reset-password/{token}', array('uses' => 'LoginController@resetPassword'));
        Route::get('logout', array('uses' => 'LoginController@doLogout'));
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/admin/dashboard', 'DashboardController@index');

        Route::get('/home-page-videos', 'DashboardController@homevideos');
        Route::get('/admin/add-home-video', 'DashboardController@addhomevideos');
        Route::post('/admin/add-home-video', 'DashboardController@addhomevideos');
        
        Route::get('/admin/viewhomevideo/{id}', 'DashboardController@addhomevideos');
        Route::get('/admin/deletehomevideo/{id}', 'DashboardController@deletehomeVideos');


        Route::get('/admin/university-listing', 'UniversityController@index');
        Route::get('/admin/add-university-video', 'UniversityController@addUniversityVideo');
        Route::post('/admin/add-university-video', 'UniversityController@addUniversityVideo');
        
        Route::get('/admin/video-university/{id}', 'UniversityController@addUniversityVideo');
        Route::get('/admin/delete-universityvideo/{id}', 'UniversityController@deleteUniversityVideo');
        
        Route::get('/admin/courses-listing', 'DashboardController@courses');
        Route::get('/admin/add-course/{id?}', 'DashboardController@addCourse');
        Route::post('/admin/add-course', 'DashboardController@addCourse');
        
        //User routes
        Route::post('/admin/save-user', 'UserController@store');
        Route::get('/admin/userview/{id}', 'UserController@showuser');
        Route::post('/admin/edituser/{id}', 'UserController@edit');
        Route::get('/admin/deleteUser/{id}', 'UserController@destroy');
        Route::get('/admin/user', 'UserController@adminUser');
        Route::get('/admin/add-user', 'UserController@addUser');
        // Setting
        Route::get('/admin/setting', 'SettingController@index');
        Route::post('/admin/edit-setting/{id}', 'SettingController@edit');
        Route::get('/admin/menu', 'SettingController@adminMenu');
        Route::get('/admin/add-menu', 'SettingController@addMenu');
        Route::post('/admin/save-menu', 'SettingController@saveMenu');
        Route::get('/admin/show-menu/{id}', 'SettingController@showMenu');
        Route::post('/admin/edit-menu/{id}', 'SettingController@editMenu');
        Route::get('/admin/delete-menu/{id}', 'SettingController@destroy');
        Route::post('/admin/changeMenuStatus', 'SettingController@changeStatus');
        Route::get('/admin/add-user-permission', 'SettingController@setPermission');
        Route::post('/admin/store-permission', 'SettingController@storePermission');
        Route::get('/admin/user-permission', 'SettingController@userPermission');
        Route::get('/admin/showpermission/{id}', 'SettingController@showUserPermission');
        Route::post('/admin/edit-permission/{id}', 'SettingController@editPermission');
        Route::get('/admin/delete-permission/{id}', 'SettingController@destroyPermission');
        Route::get('/admin/contact', 'SettingController@getContactInfo');
        
        //Collage Management
        Route::get('admin/college-list', 'CollageDashboardController@index');
        Route::get('admin/university-list', 'CollageDashboardController@unilist');
        Route::get('admin/add-college', 'CollageDashboardController@add');
        Route::get('admin/add-scolarship', 'CollageDashboardController@addCollScolar');
        Route::get('admin/edit-college/{id}', 'CollageDashboardController@show');
        Route::get('admin/edit-scholarship/{id}', 'CollageDashboardController@showScholarship');
        Route::get('admin/delete-gallery/{id}', 'CollageDashboardController@delGallery');
        Route::get('admin/edit-university/{id}', 'CollageDashboardController@showUni');
        Route::post('admin/edit-college/{id}', 'CollageDashboardController@edit');
        Route::get('admin/edit-gallery/{id}', 'CollageDashboardController@editGallery');
        Route::get('admin/add-gallery', 'CollageDashboardController@addCollGallery');
        Route::get('admin/add-university', 'CollageDashboardController@addUniversity');
        Route::post('/admin/changeUserStatus', 'CollageDashboardController@changeStatus');
        Route::post('admin/save-college', 'CollageDashboardController@save');
        Route::post('admin/save-gallery', 'CollageDashboardController@saveGallery');
        Route::post('admin/save-scolarship', 'CollageDashboardController@savescholar');
        Route::get('admin/deletecollege/{id}', 'CollageDashboardController@delCollege');
        Route::get('admin/delete-university/{id}', 'CollageDashboardController@delUni');

        //College Course
        Route::get('admin/view-course/{id}', 'CourseController@index');
        Route::get('admin/add-courses', 'CourseController@addCourse');
        Route::post('admin/save-course', 'CourseController@saveCourse');
        Route::get('admin/edit-course/{id}', 'CourseController@show');
        Route::post('admin/edit-course/{id}', 'CourseController@edit');
        Route::get('admin/delete-course/{id}', 'CourseController@destroy');
        Route::post('admin/getCourseName', 'CourseController@getCourseName');

        //College Career

        Route::get('admin/career', 'CareerController@index');
        Route::get('admin/add-career', 'CareerController@add');
        Route::post('admin/save-career', 'CareerController@saveCareer');
        Route::get('admin/show-career/{id}', 'CareerController@show');
        Route::get('admin/edit-sub-career/{id}', 'CareerController@showSubCareer');
        Route::post('admin/edit-career/{id}', 'CareerController@edit');
        Route::get('admin/delete-career/{id}', 'CareerController@destroy');
        Route::post('/admin/changeCareerStatus', 'CareerController@changeStatus');
        Route::get('admin/show-career-video/{id}/{career_id}', 'CareerController@showCareerVideo');
        Route::get('admin/add-career-video/{career_id}', 'CareerController@addCareerVideo');
        Route::post('/admin/save-career-video', 'CareerController@saveCareerVideo');
        Route::get('admin/edit-career-video/{career_id}/{id}/{subcareer_id}', 'CareerController@editCareerVideo');
        Route::post('admin/edit-career-video/{id}', 'CareerController@updateCareerVideo');
        Route::get('admin/delete-career-video/{type}/{video}/{thumb}/{id}', 'CareerController@deleteCareerVideo');
        Route::get('admin/changeVideoPriority/{id}', 'CareerController@changeVideoPriority');
        
        //Scholership
        Route::get('admin/delete-career/{type}/{id}', 'CareerController@destroy');
        Route::get('admin/add-examination/{career_id}', 'CareerController@addExam');
        Route::post('admin/save-career-exam', 'CareerController@saveExam');
        Route::get('admin/edit-career-exam/{career_id}/{id}', 'CareerController@showExam');
        Route::post('admin/edit-career-exam', 'CareerController@editExam');
        Route::get('admin/add-career-scholarship/{career_id}', 'CareerController@addScholarship');
        Route::post('admin/save-career-scolarship', 'CareerController@saveScholarship');
        Route::get('admin/edit-career-scholarship/{career_id}/{id}', 'CareerController@showScholarship');
        Route::get('admin/changesvideostatus/{post_id}/{status}', 'CareerController@changesvideostatus');
        
        //inspiring videos
        Route::get('admin/inspiringvideo', 'InspiringVideoController@index');
        Route::get('admin/add-inspring-video', 'InspiringVideoController@add');
        Route::post('admin/save-inspiring-video', 'InspiringVideoController@save');
        Route::get('admin/edit-inspiring-video/{id}', 'InspiringVideoController@show');
        Route::post('admin/edit-inspiring-video/{id}', 'InspiringVideoController@edit');
        Route::get('admin/delete-inspiring-video/{id}', 'InspiringVideoController@destroy');
        Route::post('/admin/changeInspiringStatus', 'InspiringVideoController@changeStatus');


        // students
        Route::get('admin/students', 'StudentController@students');
        Route::get('admin/studentview/{id}', 'StudentController@studentView');
        Route::get('admin/students/{type}', 'StudentController@filterStudents');
        Route::get('admin/students/status', 'StudentController@changestudentStatus');
        Route::get('admin/updateStaudent/{type}/{id}','StudentController@updateStaudent');
        Route::get('admin/edit-user-sop/{type}/{id}','StudentController@getsopanswer');
        Route::get('admin/delete-sop-video/{filename}/{id}','StudentController@deleteSopVideo');
        Route::get('admin/delete-sop-text/{id}','StudentController@deleteSopText');
        //Sop
        Route::get('admin/video-sop', 'StudentController@videoSop');
        Route::get('admin/text-sop', 'StudentController@textSop');
        Route::post('admin/editsop/{id}', 'StudentController@editSop');


        //Home Video
        Route::get('admin/static-page-video-list', 'InspiringVideoController@SatticPageVideo');
        Route::get('admin/edit-static-page-videos/{id}/{type}', 'InspiringVideoController@editHomeVideo');
        Route::post('admin/edit-home-video/{id}', 'InspiringVideoController@saveHomeVideo');

        //School List
        Route::get('admin/school-list', 'SchoolController@index');
        Route::get('admin/add-school', 'SchoolController@add');
        Route::post('/admin/save-school', 'SchoolController@save');
        Route::get('admin/edit-school/{id}', 'SchoolController@show');
        Route::post('admin/edit-school/{id}', 'SchoolController@edit');
        Route::get('admin/delete-school/{id}', 'SchoolController@destroy');
       // Route::post('admin/generate-licence-code', 'SchoolController@generateLicenceCode');
        Route::get('admin/generate-licence-code', 'SchoolController@generateLicenceCode');
        Route::get('admin/assign-code', 'SchoolController@assignCode');
        Route::get('admin/save-assign-code', 'SchoolController@saveAssignCode');

        // Category Admin Route
        Route::get('admin/category', 'CategoryController@index');
        Route::post('admin/addcategory', 'CategoryController@store');
        Route::get('admin/show/{id}', 'CategoryController@show');
        Route::get('admin/deleteImg/{img}/{id}', 'CategoryController@delImg');
        Route::post('admin/editcategory/{id}', 'CategoryController@edit');
        Route::get('admin/deleteCategory/{id}', 'CategoryController@destroy');
        // Post Admin Route
        Route::get('admin/post', 'PostController@index');
        Route::get('admin/addpost', 'PostController@add');
        Route::post('admin/storepost', 'PostController@store');
        Route::get('admin/editpost/{id}', 'PostController@show');
        Route::get('admin/deleteimage/{img}/{id}', 'PostController@delImg');
        Route::post('admin/updatepost/{id}', 'PostController@edit');
        Route::get('admin/deletePost/{id}', 'PostController@destroy');
        Route::get('admin/getbtncolor', 'SettingController@getbtncolor');
        Route::get('admin/PostCommentapproved/{postid}/{id}/{status}', 'PostController@PostCommentApproved');
        Route::get('admin/changesposttatus/{post_id}/{status}', 'PostController@changePostStatus');
        
        //Featured videos
        Route::get('admin/featuredvideolist', 'FeaturedVideoController@index');
        Route::get('admin/add-featured-video', 'FeaturedVideoController@add');
        Route::post('admin/save-featured-video', 'FeaturedVideoController@save');
        Route::get('admin/edit-featured-video/{id}', 'FeaturedVideoController@show');
        Route::post('admin/edit-featured-video/{id}', 'FeaturedVideoController@edit');
        Route::get('admin/delete-featured-video/{id}', 'FeaturedVideoController@destroy');
        Route::post('/admin/changeFeaturedVideoStatus', 'FeaturedVideoController@changeStatus');
        
        //OurTeam
        Route::get('admin/team-list', 'OurTeamController@index');
        Route::get('admin/team-list/{type}', 'OurTeamController@index');
        Route::get('admin/add-team', 'OurTeamController@add');
        Route::post('admin/save-team', 'OurTeamController@store');
        Route::get('admin/edit-team/{id}', 'OurTeamController@show');
        Route::post('admin/edit-team/{id}', 'OurTeamController@edit');
        Route::get('admin/delete-team/{id}', 'OurTeamController@destroy');
        Route::post('/admin/changeTeamStatus', 'OurTeamController@changeStatus');

        //Edieo
        Route::get('admin/edieo-video-list', 'EdieoController@index');
        Route::get('admin/add-edieo-video', 'EdieoController@add');
        Route::post('admin/save-edieo-video', 'EdieoController@store');
        Route::get('admin/edit-edieo/{id}', 'EdieoController@show');
        Route::post('admin/edit-edieo/{id}', 'EdieoController@edit');
        Route::get('admin/delete-edieo/{id}', 'EdieoController@destroy');
        Route::post('/admin/changeEdieoStatus', 'EdieoController@changeStatus');
        Route::get('admin/change-video-priority/{id}', 'EdieoController@changeVideoPriority');


        //Nano Class
        Route::get('admin/nano-class-video-list/{id}', 'NanoClassController@index');
        Route::get('admin/add-nano-class-video/{cid}', 'NanoClassController@add');
        Route::post('admin/save-nano-video', 'NanoClassController@store');
        Route::get('admin/edit-nano-class/{id}', 'NanoClassController@show');
        Route::post('admin/update-nano-class/{id}', 'NanoClassController@edit');
        Route::get('admin/delete-nano-class/{id}', 'NanoClassController@destroy');
        Route::post('/admin/changeNanoStatus', 'NanoClassController@changeStatus');

    });
});
