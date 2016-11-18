<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */

Route::group(['middleware' => ['web' ] ],
             function () {

    Route::model('entreaty',
                 'App\Entreaty',
                 function() {
        throw new NotFoundHttpException;
    });

    Route::get('/',
               function () {
        return view('welcome');
    })->middleware('guest');

    Route::post('','NewController@index');

    Route::get('thank_you',function(){
      return view('thank_you');
    });

    Route::get('error',function(){
      return view('error');
    });

    Route::get('access/{id?}','NewController@access');

    Route::get('/entreaties',
               'EntreatyController@index');
    
    Route::post('/entreaty',
                'EntreatyController@store');
    
    Route::get('/entreaty/{entreaty}',
               'EntreatyController@view');
    
    Route::delete('/entreaty/{entreaty}',
                  'EntreatyController@destroy');

    Route::get('/pay/entreaty/{entreaty}',
               'AttemptController@initiate');
    
    Route::get('/paystack-callback',
               'AttemptController@verify');

    Route::auth();
});
