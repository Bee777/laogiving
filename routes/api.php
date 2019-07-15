<?php
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
/******************** @GuestUserSection ****************** */
Route::group(['prefix' => '/guest', 'middleware' => ['cors']], function () {
    Route::post('/login', 'Auth\LoginController@login')->name('api.post.login');
    Route::post('/register-user', 'Auth\RegisterController@register')->name('api.post.register');
    //Users Email Forgot Password
    Route::post('/forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('api.post.send-user-reset-link');
    Route::post('/forgot-password/email/{token}', 'Auth\ForgotPasswordController@getEmailFromToken')->name('api.post.getEmailFromToken');
    //Users Password Reset
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('api.post.resetPassword');
});
/******************** @GuestUserSection ****************** */

/******************** @HomeSection ****************** */
Route::group(['prefix' => '/home', 'middleware' => ['cors', 'parseToken:guest-bearer']], function () {
    Route::get('/index', 'HomeController@index')->name('api.get.home.index');
    /*********@Posts */
    Route::get('/posts/{type}', 'HomeController@responsePosts')->name('get.home.posts');
    Route::get('/posts/{type}/single/{id}', 'HomeController@responsePostsSingle')->name('get.home.posts.single');
    /********* @Posts */
    /****@ContactInfo */
    Route::post('/contact-info', 'HomeController@responsePostContactInfo')->name('api.post.contactInfo');
    /****@ContactInfo */
    /****@NewsLetter */
    Route::post('/save-receive-news-letter', 'HomeController@responsePostNewsLetter')->name('api.post.saveNewsLetter');
    /****@NewsLetter */
    /****@ReportAbuse */
    Route::post('/send-report-abuse', 'HomeController@responsePostReportAbuse')->name('api.post.sendReportAbuse');
    /****@ReportAbuse */
});
/******************** @HomeSection ****************** */

Route::group(['prefix' => '/', 'middleware' => ['cors', 'parseToken', 'auth:api']], function () {
    /**
     ***************** @AdminSection routes ************************
     */
    Route::group(['prefix' => '/admin', 'middleware' => []], function () {
        /*** @Searches ** */
        Route::get('/searches/{type}', 'AdminController@responseSearches')->name('api.admin.get.searches');
        /*** @Searches ** */
        /*** @Users actions ** */
        Route::post('/users-register', 'AdminController@responseActionAddUser')->name('api.admin.post.users.addUser');
        Route::post('/users-change-status/{id}', 'AdminController@responseActionChangeUserStatus')->name('api.admin.post.users.changeStatus');
        Route::post('/users-delete/{id}', 'AdminController@responseActionDeleteUser')->name('api.admin.post.users.deleteUser');
        /*** @Users actions ** */

        /*** @SiteInfo ** */
        Route::post('site-info/manage', 'AdminController@responseActionManageSiteInfo')->name('api.admin.post.site-info.manage');
        Route::get('site-info', 'AdminController@getSiteInfo')->name('api.admin.get.site-info');
        /*** @SiteInfo ** */

        /*** @News ** */
        Route::post('/news/create', 'AdminController@insertNews');
        Route::post('/news/update/{id}', 'AdminController@updateNews');
        Route::delete('/news/delete/{id}', 'AdminController@DeleteNews');
        /***@News ** */
        /*** @Activity ** */
        /***@Activity ** */

        /***@ContactInfo ** */
        Route::get('/contactinfo', 'AdminController@getContactInfo');
        Route::post('/contactinfo/manage', 'AdminController@manageContactInfo');
        /** @ContactInfo ** */
        /***@AboutInfo ** */
        Route::get('/aboutinfo', 'AdminController@getAboutInfo');
        Route::post('/aboutinfo/manage', 'AdminController@manageAboutInfo');
        /** @AboutInfo ** */
        /***@Banner ** */
        Route::post('/banner/create', 'AdminController@insertBanner');
        Route::post('/banner/update/{id}', 'AdminController@updateBanner');
        Route::delete('/banner/delete/{id}', 'AdminController@deleteBanner');
        /***@Banner ** */
        /***@Volunteering ** */
        Route::group(['prefix' => '/volunteering', 'middleware' => []], function () {
            /*** @Causes ** */
            Route::post('/category/create', 'AdminController@responseActionCreateCauses')->name('api.admin.post.volunteering.causes.create');
            Route::post('/category/update/{id}', 'AdminController@responseActionUpdateCauses')->name('api.admin.post.volunteering.causes.update');
            Route::delete('/category/delete/{id}', 'AdminController@responseActionDeleteCauses')->name('api.admin.delete.volunteering.causes.delete');
            /*** @Causes ** */
            /*** @Skills ** */
            Route::post('/skill/create', 'AdminController@responseActionCreateSkill')->name('api.admin.post.volunteering.skill.create');
            Route::post('/skill/update/{id}', 'AdminController@responseActionUpdateSkill')->name('api.admin.post.volunteering.skill.update');
            Route::delete('/skill/delete/{id}', 'AdminController@responseActionDeleteSkill')->name('api.admin.delete.volunteering.skill.delete');
            /*** @Causes ** */
            /*** @Suitable ** */
            Route::post('/suitable/create', 'AdminController@responseActionCreateSuitable')->name('api.admin.post.volunteering.suitable.create');
            Route::post('/suitable/update/{id}', 'AdminController@responseActionUpdateSuitable')->name('api.admin.post.volunteering.suitable.update');
            Route::delete('/suitable/delete/{id}', 'AdminController@responseActionDeleteSuitable')->name('api.admin.delete.volunteering.skill.delete');
            /*** @Suitable ** */
            /*** @VolunteeringManage  ** */
            Route::post('/change-status/{id}', 'AdminController@responseActionChangeVolunteeringStatus')->name('api.admin.post.volunteering.change.status');
            Route::delete('/delete/{id}', 'AdminController@responseActionDeleteVolunteering')->name('api.admin.post.volunteering.delete');
            /*** @VolunteeringManage ** */

        });
        /***@Volunteering ** */
        /*** @UploadPostsImage * */
        Route::post('posts/upload-images', 'AdminController@responseActionUploadImages')->name('api.admin.post.posts.uploadImages');
        Route::get('/posts/get-images', 'AdminController@responseActionGetImages')->name('api.admin.post.posts.getImages');
        Route::post('posts/delete-images/', 'AdminController@responseActionDeleteImages')->name('api.admin.delete.posts.delete');
        /*** @UploadPostsImage * */
        /*** @SendUserResetPasswordLink * */
        Route::post('/users-send-reset-password-link/{id}', 'AdminController@responseActionSendUserResetPasswordLink')->name('api.admin.post.users.sendResetPasswordLink');
        /*** @SendUserResetPasswordLink * */
        /*** @postManagePostsStatus * */
        Route::post('posts-status/manage', 'AdminController@responseActionManagePostsStatus')->name('api.admin.post.posts.ManagePostsStatus');
        /*** @postManagePostsStatus * */
    });
    /**
     ***************** @AdminSection routes ************************
     */
    /******************** @UserSection ****************** */
    Route::group(['prefix' => '/users', 'middleware' => []], function () {
        /****@FetchSignUpVolunteeringSuccess */
        Route::get('/fetch-signup-volunteering-success/{activity_id}', 'UserController@responseFetchSignUpVolunteeringSuccess')->name('api.get.fetchVolunteeringSignUpSuccess');
        /****@FetchSignUpVolunteeringSuccess */
        /****@SaveSignUpVolunteering */
        Route::post('/save-signup-volunteering', 'UserController@responsePostSaveSignUpVolunteering')->name('api.post.saveVolunteering');
        /****@SaveSignUpVolunteering */
        /****@SaveBookmark */
        Route::post('/save-post-bookmark', 'HomeController@responsePostSaveBookmark')->name('api.post.saveBookmark');
        /****@SaveBookmark */
        Route::post('me', 'UserController@me')->name('api.user.post.me');
        /*** @Searches ** */
        Route::get('/searches/{type}', 'UserController@responseSearches')->name('api.user.get.searches');
        /*** @Searches ** */
        /*** @UserProfileSettings ** */
        Route::post('/visibility-profile-manage', 'UserController@responseVisibilityProfileManage')->name('api.user.get.responseVisibilityProfileManage');
        Route::get('/profile-options', 'UserController@responseProfileOptions')->name('api.user.get.profileOptions');
        Route::post('/profile-manage', 'UserController@responseProfileManage')->name('api.user.get.responseProfileManage');
        /*** @UserProfileSettings ** */
        Route::post('/credentials-manage', 'UserController@responseCredentialsManage')->name('api.user.get.credentialsManage');
        /*** @UserProfileSettings ** */
        /*** @DashboardData Make it can accessible for admin and user * */
        Route::get('/dashboard-data', 'UserController@responseDashboardData')->name('api.user.get.dashboardData');
        /*** @DashboardData Make it can accessible for admin and user * */
        /***@AutoUserLogin */
        Route::post('auto-login', 'UserController@responseActionUserAutoLogin')->name('api.users.post.UserAutoLogin');
        /***@AutoUserLogin */
        /*** @UserVolunteeringActivity ** */
        Route::get('/volunteering-activity-options', 'UserController@responseVolunteeringActivityOptions')->name('api.user.get.volunteeringActivity');
        Route::post('/volunteering-activity-create', 'UserController@responseVolunteeringActivityCreate')->name('api.user.create.volunteeringActivity');
        Route::post('/volunteering-activity-update/{id}', 'UserController@responseVolunteeringActivityUpdate')->name('api.user.update.volunteeringActivity');
        Route::delete('/volunteering-activity-discard/{id}', 'UserController@responseVolunteeringActivityDiscard')->name('api.user.discard.volunteeringActivity');
        Route::get('/volunteering-activity-manager/{id}', 'UserController@responseVolunteeringActivityManager')->name('api.user.manage.volunteeringActivity');
        Route::post('/volunteering-activity-manager-change-status/{id}', 'UserController@responseVolunteeringActivityManagerChangeStatus')->name('api.user.manage-change-status.volunteeringActivity');
        /*** @UserVolunteeringActivity ** */
        /*** @UserVolunteeringSigupManage ** */
        Route::post('/volunteering-signup/change-status/{id}', 'UserController@responseVolunteeringSignUpChangeStatus')->name('api.user.manage-change-status.volunteeringSignUp');
        Route::post('/volunteering-signup/all-change-status', 'UserController@responseAllVolunteeringSignUpChangeStatus')->name('api.user.manage-all-change-status.volunteeringSignUp');
        Route::post('/volunteering-signup/all-change-attendance', 'UserController@responseAllVolunteeringSignUpChangeAttendance')->name('api.user.manage-all-change-attendance.volunteeringSignUp');
        Route::get('/volunteering-fetch-all-volunteers', 'UserController@responseFetchAllSignUpVolunteers')->name('api.user.fetch-all-volunteers.volunteeringSignUp');
        /*** @UserVolunteeringSigupManage ** */
        /*********@Posts */
        Route::get('/posts/{type}', 'UserController@responsePosts')->name('api.users.postsResponse');
        /*********@Posts */
    });
    /******************** @UserSection ****************** */
    /** @Logout */
    Route::post('/logout', 'Auth\LoginController@logout')->name('api.get.logout');
    /** @Logout */
});
