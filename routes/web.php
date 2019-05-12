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

Route::get('/', 'HomeController@index')->name('get.home.index');

Route::get('/login', 'HomeController@index')->name('get.home.login');
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
Route::get('posts/volunteer-activity/{id}', 'HomeController@index')->name('get.home.volunteer.activity');
Route::get('/organisation/profile/{id}', 'HomeController@index')->name('get.home.organize.profile');
/**@Posts */

/**@ResetPasswordForm */
Route::get('password/reset/{token}', 'HomeController@index')->name('password.reset');
Route::get('/reset-password-successfully', 'HomeController@index')->name('get.home.reset-password-successfully');
/**@ResetPasswordForm */

/***** @VolunteerRoutes ***** */
$user_prefixs = ['volunteer', 'organize', 'admin'];
Route::group(['prefix' => $user_prefixs[0] . '/me', 'middleware' => []], function () use ($user_prefixs) {
    Route::get('/', ucfirst($user_prefixs[0]) . 'Controller@index')->name("get.{$user_prefixs[0]}.index");
});
/***** @VolunteerRoutes ***** */

/***** @OrganizeRoutes ***** */
Route::group(['prefix' => $user_prefixs[1] . '/me', 'middleware' => []], function () use ($user_prefixs) {
    Route::get('/', ucfirst($user_prefixs[1]) . 'Controller@index')->name("get.{$user_prefixs[1]}.index");
    Route::get('/all-volunteers', ucfirst($user_prefixs[1]) . 'Controller@index')->name("get.{$user_prefixs[1]}.all-volunteers");
    Route::get('/manage-sign-up-volunteers', ucfirst($user_prefixs[1]) . 'Controller@index')->name("get.{$user_prefixs[1]}.manage-sign-up-volunteers");
    Route::get('/create-activity', ucfirst($user_prefixs[1]) . 'Controller@index')->name("get.{$user_prefixs[1]}.create-activity");
});
/***** @VolunteerRoutes ***** */







