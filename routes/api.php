<?php

use Illuminate\Http\Request;

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
// Route::group(['middleware' => ['cors']], function(){

Route::get('/currencies/{secret}', 'ApiController@allCurrencies')->name('currency');

Route::get('/currencychange/{actualcurrency}/{newcurrency}/{secret}', 'ApiController@getCurrencyChange')->name('currencychange');

Route::get('/salaries/{index}/{secret}', 'ApiController@salaryCities')->name('salaries');

Route::get('/citydata/{city}/{country}/{secret}', 'ApiController@cityData')->name('cityData');

Route::get('/countrydata/{country}/{secret}', 'ApiController@countryData')->name('countryData');

Route::get('/worldcities/{text}/{secret}', 'ApiController@worldCities')->name('worldCities');

Route::get('/allcities/{secret}', 'ApiController@allCities')->name('allCities');

Route::get('/getToken/{ip}', 'ApiController@assignToken')->name('getToken');
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
