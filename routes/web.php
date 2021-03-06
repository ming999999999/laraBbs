<?php

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/','TopicsController@index')->name('root');

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


// 分类列表话题
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);


// 图片上传
Route::post('upload_image','TopicsController@uploadImage')->name('topics.upload_image');


// 帖子的回复功能
Route::resource('replies', 'RepliesController', ['only' => ['store','destroy']]);


// 
Route::resource('notifications','NotificationsController',['only'=>['index']]);


// 角色权限测试路由
Route::get('upr','UprController@index')->name('upr');


// 无权限提醒路由
Route::get('permission-denied','PagesController@permissionDenied')->name('permission-denied');

