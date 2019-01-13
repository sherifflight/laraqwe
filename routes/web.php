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

Route::group(['namespace' => 'Front'], function () {

    Route::get('/', 'MainController@index')->name('front');
});

Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard'], function () {

    Route::group(['middleware' => 'guest:dashboard'], function () {

        Route::get('login',  'AuthController@login')->name('dashboard.login');
        Route::post('login', 'AuthController@authenticate');
    });

    Route::group(['middleware' => 'auth:dashboard'], function () {

        Route::get('logout', 'AuthController@logout')->name('dashboard.logout');

        Route::get('/', 'UsersController@index')->name('dashboard');

        Route::group(['prefix' => 'users', 'middleware' => 'can.access:users'], function () {

            Route::get('/', 'UsersController@index')->name('dashboard.users.index');

            Route::group(['middleware' => 'can.modify:users'], function() {

                Route::get('create', 'UsersController@create')->name('dashboard.users.create');
                Route::post('create', 'UsersController@store')->name('dashboard.users.store');
                Route::get('{id}/edit', 'UsersController@edit')->name('dashboard.users.edit');
                Route::post('{id}/edit', 'UsersController@update')->name('dashboard.users.update');
                Route::post('{id}/delete', 'UsersController@delete')->name('dashboard.users.delete');
            });

            Route::post('stores-select', 'UsersController@storesSelect')->name('dashboard.users.storesSelect');
        });

        Route::group(['prefix' => 'pages', 'middleware' => 'can.access:pages'], function () {

            Route::get('/', 'PagesController@index')->name('dashboard.pages.index');

            Route::group(['middleware' => 'can.modify:pages'], function () {

                Route::get('{id}/edit', 'PagesController@edit')->name('dashboard.pages.edit');
                Route::post('{id}/edit', 'PagesController@update')->name('dashboard.pages.update');
            });
        });
    });
});
