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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['middleware'=> 'web'], function() {

    Route::match(['get', 'post'], '/', ['uses'=>'IndexController@execute', 'as'=>'home']);
    Route::get('/page/{alias}', ['uses'=>'PageController@execute', 'as'=>'page']);

    Route::auth();


});

/**
 * Admin service
 */
Route::group(['prefix'=>'admin', 'middleware'=>'auth'], function() {


    //admin
    Route::get('/', function() {


    });

    //admin/pages
    Route::group(['prefix'=>'pages'], function() {

        Route::get('/', ['uses'=>'PagesController@execute', 'as'=>'pages']);
        Route::match(['get', 'post'], '/add', ['uses'=>'PagesAddController@execute', 'as'=>'pagesAdd']);
        Route::match(['get', 'post', 'delete'], '/edit/{page}', ['uses'=>'PagesEditController@execute', 'as'=>'pagesEdit']);

    });

    //portfolios/pages
    Route::group(['prefix'=>'portfolios'], function() {

        Route::get('/', ['uses'=>'PortfoliosController@execute', 'as'=>'portfolios']);
        Route::match(['get', 'post'], '/add', ['uses'=>'PortfoliosAddController@execute', 'as'=>'PortfoliosAdd']);
        Route::match(['get', 'post', 'delete'], '/edit/{portfolios}', ['uses'=>'PortfoliosEditController@execute', 'as'=>'PortfoliosEdit']);

    });

    //services/pages
    Route::group(['prefix'=>'services'], function() {

        Route::get('/', ['uses'=>'ServicesController@execute', 'as'=>'services']);
        Route::match(['get', 'post'], '/add', ['uses'=>'ServicesAddController@execute', 'as'=>'ServicesAdd']);
        Route::match(['get', 'post', 'delete'], '/edit/{services}', ['uses'=>'ServicesEditController@execute', 'as'=>'ServicesEdit']);

    });
});


