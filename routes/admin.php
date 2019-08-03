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
    Route::get('/volunteer', 'AdminController@index')->name('admin.get.index.volunteer');
    Route::get('/organize', 'AdminController@index')->name('admin.get.index.organize');
    Route::get('/volunteer-activities', 'AdminController@index')->name('admin.get.index.volunteer-activities');
    Route::get('/site-setting', 'AdminController@index')->name('admin.get.site-setting');
    Route::get('/contact-info', 'AdminController@index')->name('admin.get.contact-info');
    Route::get('/about', 'AdminController@index')->name('admin.get.about');
    Route::get('/news', 'AdminController@index')->name('admin.get.news');
    Route::get('/causes', 'AdminController@index')->name('admin.get.causes');
    Route::get('/skill', 'AdminController@index')->name('admin.get.skill');
    Route::get('/suitable', 'AdminController@index')->name('admin.get.suitable');

});
