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

//Define all routes for the laravel bookstore project
Route::get('/', 'BookstoreController@indexAction');
Route::get('/store/browse', 'BookstoreController@browseAction');
Route::any('/store/search', 'BookstoreController@searchAction');
Route::get('/store/select/{id}', 'BookstoreController@selectAction');
Route::any('/store/register', 'BookstoreController@registerAction');
Route::any('/store/login', 'BookstoreController@loginAction');
Route::get('/store/user', 'BookstoreController@userAction');
Route::post('/store/user/{field}', 'BookstoreController@userchangeAction');
Route::any('/store/logout', 'BookstoreController@logoutAction');
Route::any('/store/addcart/{id}', 'BookstoreController@AddCartAction');
Route::any('/store/checkremovecart/{id}', 'BookstoreController@checkRemoveCartAction');
Route::any('/store/checkout', 'BookstoreController@checkoutAction');
Route::any('/store/removecart/{id}', 'BookstoreController@RemoveCartAction');
Route::any('/store/viewcart', 'BookstoreController@ViewCartAction');
Route::any('store/receipt', 'BookstoreController@receiptAction');

Route::get('/store/rate/{rating}', 'BookstoreController@RateAction');
// Set default route to match all other cases
Route::any('{all}', 'BookstoreController@indexAction')->where('all', '.*');