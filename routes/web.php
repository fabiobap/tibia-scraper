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

Route::get('/servers', 'ServersController@index')
    ->name('servers_list');
Route::post('/servers', 'ServersController@store');
Route::get('/servers/create', 'ServersController@create')
    ->name('form_create_server');
Route::delete('/servers/{id}', 'ServersController@destroy');

Route::get('/bosses', 'BossesController@index')
    ->name('bosses_list');
Route::get('/bosses/create', 'BossesController@create')
    ->name('form_create_boss');
Route::post('/bosses/create', 'BossesController@store');
Route::delete('/bosses/{id}', 'BossesController@destroy');

Route::get('/sightings', 'BossSightingsController@index')
    ->name('boss_sightings_list');
Route::post('/sightings', 'BossSightingsController@store');
Route::delete('/sightings/{id}', 'BossSightingsController@destroy');

Route::get('/predictions/base', 'PredictionsBaseController@index')
    ->name('base_list');
Route::get('/predictions/base/create', 'PredictionsBaseController@create')
    ->name('form_create_base_stats');
Route::post('/predictions/base/create', 'PredictionsBaseController@store');
Route::delete('/predictions/base/{id}', 'PredictionsBaseController@destroy');

Route::get('/predictions', 'PredictionsController@index')
    ->name('predictions_list');
Route::post('/predictions/create', 'PredictionsController@store');
Route::post('/predictions/update', 'PredictionsController@update');
Route::delete('/predictions/{id}', 'PredictionsController@destroy');