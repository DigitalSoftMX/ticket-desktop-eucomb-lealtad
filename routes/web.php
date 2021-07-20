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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('auth.login');
});

Route::get('/graphics', function () {
	return view('Graphics.graphics');
});

Route::get('/logout', function () {
	return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
	Route::get('litersMountYears', 'HomeController@litersMountYears')->name('litersMountYears')->middleware('auth');
	Route::get('estacion/{id}', 'HomeController@show')->name('estacion')->middleware('auth');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	// ruta que ya no se usa
	Route::resource('clients', 'Web\ClientController', ['except' => ['create', 'store', 'destroy']]);
	Route::post('lookingforclients/{view?}', 'Web\ClientController@lookingForClients')->name('lookingforclients');
	Route::get('search_client', 'Web\ClientController@search_client')->name('clients.search_client');
	Route::get('clients/points/{client}', 'Web\ClientController@points')->name('clients.points');
	Route::get('points', 'Web\ClientController@historypoints')->name('history.points');
	Route::get('clients/exchanges/{client}', 'Web\ClientController@exchange')->name('clients.exchanges');
	Route::get('getexchanges', 'Web\ClientController@getexchanges')->name('getexchanges');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
//rutas para los administradores
Route::group(['middleware' => 'auth'], function () {
	Route::resource('admins', 'Web\AdminController');
	Route::resource('invited', 'Web\InvitedController', ['only' => ['index', 'show']]);
	Route::get('getsales/{station}/{month}/{invited?}', 'Web\InvitedController@getSales')->name('getsales');
	Route::get('company', 'Web\AdminController@editCompany')->name('company');
	Route::patch('company/{company}', 'Web\AdminController@updateCompany')->name('company.update');
	Route::post('admins/schedules', 'Web\AdminController@getSchedules')->name('admins.schedules');
});
// Rutas para los despachadores
Route::group(['middleware' => 'auth'], function () {
	Route::resource('dispatchers', 'Web\DispatcherController', ['except' => ['show']]);
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('balance', 'Web\BalanceController');
	Route::post('balance/accept/{deposit}', 'Web\BalanceController@acceptBalance')->name('balance.accept');
	Route::post('balance/denny/{deposit}', 'Web\BalanceController@denyBalance')->name('balance.denny');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user_history', 'Web\UserHistoryController');
});

// Rutas para las estaciones
Route::group(['middleware' => 'auth'], function () {
	Route::resource('stations', 'Web\StationController');
	Route::resource('stations/{station}/schedules', 'Web\ScheduleController');
	Route::resource('stations/{station}/islands', 'Web\IslandController');
	Route::resource('stations/{station}/dispatcher', 'Web\DispatcherController');
	Route::resource('stations/{station}/balances', 'Web\BalanceController');
});
// Rutas para los vales
Route::group(['middleware' => 'auth'], function () {
	Route::resource('vouchers', 'Web\VoucherController', ['except' => ['show']]);
	Route::resource('countvouchers', 'Web\CountVoucherController', ['except' => ['index', 'edit', 'update', 'show', 'destroy']]);
	Route::get('exchanges', 'Web\ExchangeController@index')->name('exchanges.index');
	Route::post('exchanges/deliver/{exchange}', 'Web\ExchangeController@deliver')->name('exchange.deliver');
	Route::post('exchanges/collect/{exchange}', 'Web\ExchangeController@collect')->name('exchange.collect');
	Route::post('exchanges/history/{exchange}', 'Web\ExchangeController@history')->name('exchange.history');
	Route::get('history', 'Web\AdminController@history');
	Route::get('getlistpoints', 'Web\AdminController@getPoints')->name('get.history');
});

// Ruta para membresias referenciadas
Route::group(['middleware' => 'auth'], function () {
	Route::resource('references', 'Web\ReferenceController', ['except' => ['store']]);
	Route::post('references/addreference/{user}/{reference}', 'Web\ReferenceController@addReference')->name('addreference');
	Route::post('references/dropreference/{user}/{reference}', 'Web\ReferenceController@dropReference')->name('dropreference');
});

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('icons', ['as' => 'pages.icons', 'uses' => 'PageController@icons']);
	Route::get('maps', ['as' => 'pages.maps', 'uses' => 'PageController@maps']);
	Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'PageController@notifications']);
	Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'PageController@rtl']);
	Route::get('tables', ['as' => 'pages.tables', 'uses' => 'PageController@tables']);
	Route::get('typography', ['as' => 'pages.typography', 'uses' => 'PageController@typography']);
	Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'PageController@upgrade']);
});
