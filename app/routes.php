<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    'uses' => 'MapController@getIndex',
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
    Route::get('help-request/new',array(
        'as' => 'helpRequestNewGet',
        'uses' => 'OfferController@getHelpRequestNew'
    ));
    Route::get('help-offer/new',array(
        'as' => 'helpOfferNewGet',
        'uses' => 'OfferController@getHelpOfferNew'
    ));
    Route::post('request',array(
        'as' => 'requestPost',
        'uses' => 'OfferController@postRequest'
    ));
    Route::get('help-request/{id}/edit',array(
        'as' => 'helpRequestEditGet',
        'uses' => 'OfferController@getHelpRequestEdit'
    ));
    Route::get('help-offer/{id}/edit',array(
        'as' => 'helpOfferEditGet',
        'uses' => 'OfferController@getHelpOfferEdit'
    ));
    Route::get('help-request/{offerId}/{requestId}/response',array(
        'as' => 'helpRequestResponseGet',
        'uses' => 'OfferController@getResponse'
    ));
    Route::get('help-offer/{offerId}/{requestId}/response',array(
        'as' => 'helpOfferResponseGet',
        'uses' => 'OfferController@getResponse'
    ));
});

Route::group(array('prefix'=>'ajax','before'=>'ajax'), function(){
    Route::get('offers',array(
        'as' => 'getOffers',
        'uses' => 'OfferController@getOffers'
    ));
    Route::get('offer/{id}',array(
        'as' => 'getOffer',
        'uses' => 'OfferController@getOffer'
    ));
    Route::get('map/settings', array(
        'as' => 'getMapSettings',
        'uses' => 'MapController@getMapSettings'
    ));
    Route::post('template', array(
        'as' => 'getTemplates',
        'uses' => 'TemplateController@getTemplate'
    ));
});
Route::group(array('prefix'=>'ajax','before'=>'ajax|auth'), function(){
    Route::post('response', array(
        'as' => 'postResponse',
        'uses' => 'OfferController@postResponse'
    ));
});

Route::get('user/{id}', array(
    'as' => 'profileGet',
    'uses' => 'UserController@getProfile',
));
Route::get('help-requests',array(
    'as' => 'helpRequestsGet',
    'uses' => 'OfferController@getHelpRequests'
));
Route::get('help-offers',array(
    'as' => 'helpOffersGet',
    'uses' => 'OfferController@getHelpOffers'
));
Route::get('help-request/{id}',array(
    'as' => 'helpRequestViewGet',
    'uses' => 'OfferController@getHelpRequestView'
));
Route::get('help-offer/{id}',array(
    'as' => 'helpOfferViewGet',
    'uses' => 'OfferController@getHelpOfferView'
));


/**
 * Admin routes
 */
Route::group(array('before' => 'basicAuth|hasPermissions', 'prefix' => Config::get('syntara::config.uri')), function() {

    Route::get('site-visits',array(
        'as' => 'getSiteVisits',
        'uses' => 'AdminStatisticsController@getSiteVisits'
    ));
    Route::get('page-views',array(
        'as' => 'getPageViews',
        'uses' => 'AdminStatisticsController@getPageViews'
    ));
    Route::get('create-response',array(
        'as' => 'getCreateResponse',
        'uses' => 'AdminStatisticsController@getCreateResponse'
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


App::error(function(ModelNotFoundException $e)
{
    return Response::view('not-found',['title' => trans('global.not-found.title')],404);
});














