<?php

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/','PagesController@root')->name('root');

// Auth::routes();
// 登錄路由
Route::get('login','Auth\LoginController@showLoginForm')->name('login');
Route::post('login','Auth\LoginController@login');
Route::post('logout','Auth\LoginController@logout')->name('logout');

// 註冊路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');



// 密碼重置路由
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password.reset','Auth\ResetPasswordController@reset');

// 用戶路由
Route::resource('users','UsersController',['only'=>['show','update','edit']]);

// 話題路由
Route::resource('topics', 'TopicsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);