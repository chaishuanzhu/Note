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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix'=>'v1','namespace' => 'Api'],function (){


    Route::post('auth/login','AuthenticateController@login');

    Route::get('articles','ArticlesController@index');
    Route::post('articles','ArticlesController@store');
    Route::get('articles/{article}','ArticlesController@show');
    Route::put('articles/{article}','ArticlesController@update');

    Route::delete('articles/{article}','ArticlesController@destroy');

    Route::post('uploadAvatar','UsersController@uploadAvatar');

    Route::get('categories','CategoriesController@index');
    Route::get('categories/all','CategoriesController@all');


    Route::get('tags','TagsController@index');


    Route::get('articles/{category}/{article}/comments','CommentsController@index');

    Route::post('articles/{category}/{article}/comments','CommentsController@store');

    Route::delete('comments/{comment}','CommentsController@destroy');


    Route::post('subscriptions','SubscriptionsController@store');
    Route::delete('subscriptions/{subscription}','SubscriptionsController@destroy');

    Route::post('image/upload','FilesController@ImageUpload');


    Route::get('{type}/{type_id}/favorites','FavoriteController@index');

    Route::post('favorites','FavoriteController@store');
    
    Route::delete('favorites','FavoriteController@destroy');

    Route::post('subscribes','SubscriptionsController@store');

    Route::delete('subscribes','SubscriptionsController@destroy');


    Route::post('special_pages','SpecialPagesController@store');


    Route::get('special_pages/{page}','SpecialPagesController@show');
    Route::put('special_pages/{page}','SpecialPagesController@update');

    Route::get('{name}/comments','CommentsController@pageComments');
    Route::post('{name}/comments','CommentsController@storePageComment');


});
