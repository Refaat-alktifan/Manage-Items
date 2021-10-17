<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ItemController@index');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('manage/items', 'HomeController@closedItems');
Route::get('manage/user', 'HomeController@users');
Route::get('manage/department', 'HomeController@department');
Route::get('manage/user/add', 'HomeController@userAdd');
Route::post('manage/user/add', 'HomeController@storeUser');
Route::post('search', 'HomeController@search');
Route::get('manage/user/{id}', 'HomeController@editUser');
Route::post('manage/user/edit/{id}', 'HomeController@updateUser');

Route::get('view', 'ItemController@support');
Route::post('view', 'ItemController@loadItem');
Route::post('additem', 'ItemController@storeItem');
Route::get('items', 'ItemController@items');
Route::get('item/{tid}', 'ItemController@viewItem');
Route::post('item/{tid}', 'ItemController@storeReply');
Route::get('item/close/{tid}', 'ItemController@close');
Route::get('item/open/{tid}', 'ItemController@open');
Route::get('manage/settings', 'HomeController@settings');
Route::post('manage/settings', 'HomeController@updateSettings');
Route::get('manage/item/delete/{tid}', 'HomeController@deleteItem');

Route::get('profile', 'HomeController@profile');
Route::post('profile', 'HomeController@updateProfile');
Route::post('profile/password', 'HomeController@updateProfilePassword');
Route::get('admin/item/{tid}', 'HomeController@viewItem');
Route::post('admin/item/{tid}', 'HomeController@storeReply');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
