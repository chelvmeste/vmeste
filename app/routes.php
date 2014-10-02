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

Route::get('/', array(
    'as' => 'homeGet',
    'uses' => 'HomeController@getIndex',
));


Route::group(array('before' => 'guest'), function() {
    Route::get('register', array(
        'as' => 'registerGet',
        'uses' => 'UserController@getRegister',
    ));
    Route::get('login', array(
        'as' => 'loginGet',
        'uses' => 'UserController@getLogin',
    ));
    Route::post('login',array(
        'as' => 'loginPost',
        'uses' => 'UserController@postLogin',
    ));
});

Route::group(array('before' => 'auth'), function() {
    Route::get('logout', array(
        'as' => 'logoutGet',
        'uses' => 'UserController@getLogout',
    ));
});











/*
 * Syntara admin interface - views extending
 */

View::composer('syntara::layouts.dashboard.master', function($view)
{
    $view->with('siteName', 'Проект "Вместе"');
    $view->nest('navPages', 'admin.left-nav');
});

















