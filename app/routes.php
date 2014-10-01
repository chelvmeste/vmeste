<?php

/*
 * Syntara admin interface - views extending
 */

View::composer('syntara::layouts.dashboard.master', function($view)
{
    $view->with('siteName', 'Проект "Вместе"');
    $view->nest('navPages', 'admin.left-nav');
});

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

Route::get('/', array(
    'as' => 'home',
    'uses' => 'HomeController@getIndex',
));

Route::get('register',array(
    'as' => 'register',
    'uses' => 'UserController@getRegister',
));
Route::get('login',array(
    'as' => 'login',
    'uses' => 'UserController@getLogin',
));





























