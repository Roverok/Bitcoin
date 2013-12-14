<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::any('/login',array(
	"uses" => "UserController@loginAction"
));

Route::any('/logout', array(
	'uses' => 'UserController@logoutAction'
));

Route::group(array('before' => 'auth'), function()
{

	Route::get('/', function()
	{
		return View::make('main');
	});

	Route::post('/getAccountInfo', array(
		"uses" => "MainController@getAccountInfo"
		));

	Route::post('/getMarketDepth2', array(
		"uses" => "MainController@getMarketDepth2"
		));

	Route::post('/getOrders', array(
		"uses" => "MainController@getOrders"
		));

	Route::post('/getTransactions', array(
		"uses" => "MainController@getTransactions"
		));

	Route::post('/getDeposits', array(
		"uses" => "MainController@getDeposits"
		));

	Route::post('/buyOrder', array(
		"uses" => "MainController@buyOrder"
		));

	Route::post('/sellOrder', array(
		"uses" => "MainController@sellOrder"
		));

	Route::post('/cancelOrder', array(
		"uses" => "MainController@cancelOrder"
		));

	Route::post('/getOrderStatus', array(
		"uses" => "MainController@getOrderStatus"
		));

});