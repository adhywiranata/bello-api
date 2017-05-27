<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('/user', 'UserController@index');
$app->post('/user', 'UserController@store');
$app->put('/user/{id}', 'UserController@update');
$app->delete('/user/{id}', 'UserController@delete');

$app->post('/user/login', 'UserController@loginApi');
//Route::get('/user', 'UserController@index');


$app->get('/buyrequest', 'BuyrequestController@index');
$app->post('/buyrequest', 'BuyrequestController@store');
$app->put('/buyrequest/{id}', 'BuyrequestController@update');
$app->delete('/buyrequest/{id}', 'BuyrequestController@delete');

$app->get('/buyrequest/{id}', 'BuyrequestController@select');
$app->post('/buyrequest/updateCustom', 'BuyrequestController@updateCustom');
$app->post('/buyrequest/keyword', 'BuyrequestController@keywordAnalytics');



$app->get('/product', 'ProductController@index');
$app->post('/product', 'ProductController@store');
$app->put('/product/{id}', 'ProductController@update');
$app->delete('/product/{id}', 'ProductController@delete');

$app->get('/product/{id}', 'ProductController@selectProductById');
$app->get('/product/keyword/{id}', 'ProductController@productListByUserId');
$app->post('/product/addCart', 'ProductController@addToCart');
$app->post('/product/viewCart', 'ProductController@selectCart');
$app->post('/product/deleteCart', 'ProductController@deleteCart');



$app->get('/productview', 'ProductviewController@index');
$app->post('/productview', 'ProductviewController@store');
$app->put('/productview/{id}', 'ProductviewController@update');
$app->delete('/productview/{id}', 'ProductviewController@delete');
