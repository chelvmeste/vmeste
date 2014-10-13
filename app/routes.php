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

Route::get(Config::get('syntara::config.uri'), array(
    'before' => 'basicAuth|hasPermissions',
    'as' => 'indexDashboard',
    'uses' => 'MrJuliuss\Syntara\Controllers\DashboardController@getIndex'
));

Route::group(array('before' => 'guest'), function() {
//    Route::get('register', array(
//        'as' => 'registerGet',
//        'uses' => 'UserController@getRegister',
//    ));
    Route::get('register-complete', array(
        'as' => 'registerComplete',
        'uses' => 'UserController@getRegisterComplete',
    ));
//    Route::post('register', array(
//        'as' => 'registerPost',
//        'uses' => 'UserController@postRegister',
//    ));
    Route::get('login', array(
        'as' => 'loginGet',
        'uses' => 'UserController@getLogin',
    ));
    Route::post('login',array(
        'as' => 'loginPost',
        'uses' => 'UserController@postLogin',
    ));
    Route::get('activate/{code}',array(
        'as' => 'activateGet',
        'uses' => 'UserController@getActivate',
    ));
    Route::get('remind',array(
        'as' => 'remindGet',
        'uses' => 'RemindersController@getRemind',
    ));
    Route::post('remind',array(
        'as' => 'remindPost',
        'uses' => 'RemindersController@postRemind',
    ));
    Route::get('reset/{token}',array(
        'as' => 'resetGet',
        'uses' => 'RemindersController@getReset',
    ));
    Route::post('reset/{token}',array(
        'as' => 'resetPost',
        'uses' => 'RemindersController@postReset',
    ));
});

Route::group(array('before' => 'auth'), function() {
    Route::get('logout', array(
        'as' => 'logoutGet',
        'uses' => 'UserController@getLogout',
    ));
    Route::get('profile-edit',array(
        'as' => 'editProfileGet',
        'uses' => 'UserController@getEditProfile',
    ));
    Route::post('profile-edit',array(
        'as' => 'editProfilePost',
        'uses' => 'UserController@postEditProfile',
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

















