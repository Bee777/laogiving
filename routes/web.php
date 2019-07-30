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

use Illuminate\Http\Request;

Route::get('/', 'HomeController@index')->name('get.home.index');

Route::get('/login', 'HomeController@index')->name('get.home.login');
Route::get('/logout', 'Auth\LoginController@sessionLogout')->name('logout');
Route::get('/users-logout', 'HomeController@index')->name('get.home.users-logout');
Route::get('/register', 'HomeController@index')->name('get.home.register');
Route::get('/register_overview', 'HomeController@index')->name('get.home.register');

Route::get('/register-successfully', 'HomeController@index')->name('get.home.register-successfully');

Route::get('/about', 'HomeController@index')->name('get.home.about');
Route::get('/contact', 'HomeController@index')->name('get.home.contact');
/**@Posts */
Route::group(['prefix' => 'posts/{type}'], function () {
    Route::get('/', 'HomeController@responsePosts')->name('get.home.posts');
    Route::get('/single/{id}', 'HomeController@responsePostsSingle')->name('get.home.posts.single');
});
Route::get('posts/volunteer-activity/{id}', 'HomeController@responseActivitySingle')->name('get.home.volunteer.activity');
Route::get('/organisation/profile/{id}', 'HomeController@responseOrganizeSingle')->name('get.home.organize.profile');
/**@Posts */

/**@ResetPasswordForm */
Route::get('/forgot-password', 'HomeController@index')->name('get.home.forgot-password')->middleware('guest');
Route::get('/password/reset/{token}', 'HomeController@index')->name('password.reset');
Route::get('/reset-password-successfully', 'HomeController@index')->name('get.home.reset-password-successfully');
/**@ResetPasswordForm */
/***** @DEFINE__NAME ***** */
$user_prefixs = ['volunteer', 'organize', 'admin'];
/***** @VolunteerRoutes ***** */
Route::group(['prefix' => $user_prefixs[0] . '/me', 'middleware' => []], function () use ($user_prefixs) {
    Route::get('/', ucfirst($user_prefixs[0]) . 'Controller@index')->name("get.{$user_prefixs[0]}.index");
    Route::get('/manage-sign-up-volunteers', ucfirst($user_prefixs[0]) . 'Controller@index')->name("get.{$user_prefixs[0]}.index");
    Route::get('/download/{type}', 'UserController@download')->name("get.{$user_prefixs[1]}.downloadFile");
});
/***** @VolunteerRoutes ***** */

/***** @OrganizeRoutes ***** */
Route::group(['prefix' => $user_prefixs[1] . '/me', 'middleware' => []], function () use ($user_prefixs) {
    Route::get('/', ucfirst($user_prefixs[1]) . 'Controller@index')->name("get.{$user_prefixs[1]}.index");
    Route::get('/all-volunteers', ucfirst($user_prefixs[1]) . 'Controller@index')->name("get.{$user_prefixs[1]}.all-volunteers");
    Route::get('/manage-sign-up-volunteers', ucfirst($user_prefixs[1]) . 'Controller@index')->name("get.{$user_prefixs[1]}.manage-sign-up-volunteers");
    Route::get('/create-activity', ucfirst($user_prefixs[1]) . 'Controller@index')->name("get.{$user_prefixs[1]}.create-activity");
    Route::get('/download/{type}', 'UserController@download')->name("get.{$user_prefixs[1]}.downloadFile");
});
/***** @VolunteerRoutes ***** */
/***@AutoUserLogin */
Route::get('/users/me/auto-login/{confirmation_token}', 'Auth\LoginController@userAutoLogin')->name('get.user.UserAutoLogin');
/***@AutoUserLogin */



Route::get('/general/guest/auth/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;
    $response = $http->post('http://localhost/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '3',
            'client_secret' => 'gy82v5GpPc3cdKqa4uHZd6LsQtuYQN1xEClCf29J',
            'redirect_uri' => 'http://localhost:7801/general/guest/auth/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});



