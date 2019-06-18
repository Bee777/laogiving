<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin/me', 'middleware' => []], function () {
    Route::get('/', 'AdminController@index')->name('admin.get.index');
    Route::get('/members', 'AdminController@index')->name('admin.get.index.members');
    Route::get('/organizations', 'AdminController@index')->name('admin.get.index.organizations');
    Route::get('/members-profile', 'AdminController@index')->name('admin.get.index.membersProfile');
    Route::get('/members-profile/{id}', 'AdminController@index')->name('admin.get.singleMemberProfile');
    Route::get('/site-setting', 'AdminController@index')->name('admin.get.site-setting');
    Route::get('/contact-info', 'AdminController@index')->name('admin.get.contact-info');
    Route::get('/about', 'AdminController@index')->name('admin.get.about');
    Route::get('/news', 'AdminController@index')->name('admin.get.news');
    Route::get('/activity', 'AdminController@index')->name('admin.get.activity');
    Route::get('/upload-files', 'AdminController@index')->name('admin.get.uploadfile');
});
