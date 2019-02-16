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

Route::match(['get','post'],'/','WelcomeController@index')->name("Index");//Index
Route::match(['get','post'],'index','WelcomeController@index');//Index
Route::match(['get','post'],'about','WelcomeController@about')->name("About");;//About

Route::get('org','OrganizationController@index')->name("OrgIndex");
Route::post('org','OrganizationController@user')->name("Login&Logout");//Login & Logout
Route::get('org/create','OrganizationController@create_form')->name("OrgCreationF");
Route::post('org/create','OrganizationController@create')->name("OrgCreation");
Route::get('org/manage','OrganizationController@manage')->name("OrgManage");
Route::post('org/manage','OrganizationController@manage_edit')->name("OrgEdit");

Route::get('curriculum','CurriculumController@index');
Route::post('curriculum','CurriculumController@index');
Route::get('curriculum/query','CurriculumController@query')->name("CurQuery");//Organization
//Route::post('curriculum/query','CurriculumController@query');//Organization
Route::get('curriculum/import','CurriculumController@import_form')->name('CurImportF');//Personal
Route::post('curriculum/import','CurriculumController@import')->name("CurImport");//Personal

Route::get('act','ActController@index');
Route::post('act','ActController@index');
Route::get('act/manage','ActController@manage');//Organization
Route::get('act/query','ActController@query');//Personal