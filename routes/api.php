<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'API\UserController@store');
Route::get('/users', 'API\UserController@index');

Route::get('/notes', 'API\NoteController@index');
Route::post('/notes', 'API\NoteController@store');          //SAVE A NEW NOTE
Route::put('/notes/{id}', 'API\NoteController@update');     //UPDATE A PREVIOUSLY SAVED NOTE
Route::delete('/notes/{id}', 'API\NoteController@destroy'); //DELETE A SAVED NOTE


Route::put('/notes/{id}/archive', 'API\NoteController@archive');        //ARCHIVE A NOTE
Route::put('/notes/{id}/unarchive', 'API\NoteController@unarchive');    //UNARCHIVE A PREVIOUSLLY ARCHIVED NOTE

Route::get('/notes/unarchived', 'API\NoteController@getUnarchived');    //LIST SAVED NOTES THAT AREN'T ARCHIVED
Route::get('/notes/archived', 'API\NoteController@getArchived');        //LIST SAVED NOTES THAT ARE ARCHIVED
