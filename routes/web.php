<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','SectionController@index');
Route::post('/destroySection','SectionController@destroySection');
Route::post('/addSection','SectionController@addSection');
Route::get('/getTestCase/{id}','SectionController@getTestCase');
Route::post('/destroyTestCase','SectionController@destroyTestCase');
Route::post('/addTestCase','SectionController@addTestCase');

