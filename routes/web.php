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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//disabling registration
Route::get('register', function () {
    echo "<h1>Curently Disabled</h1>";
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');


Route::middleware('auth')->group(function () {
    // Route::get('GoldCalc_1USD', 'GoldCalcController@getINRto1USD');
    // Route::get('GoldCalc_10gGold', 'GoldCalcController@getINRto10gGOLD');




    Route::resource('Employee','EmployeeController');
    
    Route::get('Create', function () {
        return view('Create');
    });

    Route::get('USDToGoldCalc', 'GoldCalcController@showCalc');

    // For ajax Request
    Route::post('getGoldandUSD', 'GoldCalcController@getGoldandUSDPrice');

    // For Send SMS
    Route::post('sendMessageToUser','GoldCalcController@sendMessageToUser');

});
