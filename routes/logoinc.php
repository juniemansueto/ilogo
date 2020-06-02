<?php

use Illuminate\Support\Str;
use ILOGO\Logoinc\Events\Routing;
use ILOGO\Logoinc\Events\RoutingAdmin;
use ILOGO\Logoinc\Events\RoutingAdminAfter;
use ILOGO\Logoinc\Events\RoutingAfter;
use ILOGO\Logoinc\Facades\Logoinc;

/*
|--------------------------------------------------------------------------
| Logoinc Routes
|--------------------------------------------------------------------------
|
| This file is where you may override any of the routes that are included
| with Logoinc.
|
*/

Route::group(['as' => 'logoinc.'], function () {
    event(new Routing());

    $namespacePrefix = '\\'.config('logoinc.controllers.namespace').'\\';

    Route::get('login', ['uses' => $namespacePrefix.'LogoincAuthController@login',     'as' => 'login']);
    Route::post('login', ['uses' => $namespacePrefix.'LogoincAuthController@postLogin', 'as' => 'postlogin']);

    Route::group(['middleware' => 'admin.user'], function () use ($namespacePrefix) {
        event(new RoutingAdmin());

        // Main Admin and Logout Route
        Route::get('/', ['uses' => $namespacePrefix.'LogoincController@index',   'as' => 'dashboard']);
        Route::post('logout', ['uses' => $namespacePrefix.'LogoincController@logout',  'as' => 'logout']);
        Route::post('upload', ['uses' => $namespacePrefix.'LogoincController@upload',  'as' => 'upload']);

        Route::get('profile', ['uses' => $namespacePrefix.'LogoincUserController@profile', 'as' => 'profile']);

        try {
            foreach (Logoinc::model('DataType')::all() as $dataType) {
                $breadController = $dataType->controller
                                 ? Str::start($dataType->controller, '\\')
                                 : $namespacePrefix.'LogoincBaseController';

                Route::get($dataType->slug.'/order', $breadController.'@order')->name($dataType->slug.'.order');
                Route::post($dataType->slug.'/action', $breadController.'@action')->name($dataType->slug.'.action');
                Route::post($dataType->slug.'/order', $breadController.'@update_order')->name($dataType->slug.'.order');
                Route::get($dataType->slug.'/{id}/restore', $breadController.'@restore')->name($dataType->slug.'.restore');
                Route::get($dataType->slug.'/relation', $breadController.'@relation')->name($dataType->slug.'.relation');
                Route::post($dataType->slug.'/remove', $breadController.'@remove_media')->name($dataType->slug.'.media.remove');
                Route::resource($dataType->slug, $breadController, ['parameters' => [$dataType->slug => 'id']]);
            }
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException("Custom routes hasn't been configured because: ".$e->getMessage(), 1);
        } catch (\Exception $e) {
            // do nothing, might just be because table not yet migrated.
        }

        // Role Routes
        Route::resource('roles', $namespacePrefix.'LogoincRoleController', ['parameters' => ['roles' => 'id']]);
		
		// Driver Routes
        Route::resource('diver', $namespacePrefix.'LogoincDriverController', ['parameters' => ['diver' => 'id']]);

        // Menu Routes
        Route::group([
            'as'     => 'menus.',
            'prefix' => 'menus/{menu}',
        ], function () use ($namespacePrefix) {
            Route::get('builder', ['uses' => $namespacePrefix.'LogoincMenuController@builder',    'as' => 'builder']);
            Route::post('order', ['uses' => $namespacePrefix.'LogoincMenuController@order_item', 'as' => 'order']);

            Route::group([
                'as'     => 'item.',
                'prefix' => 'item',
            ], function () use ($namespacePrefix) {
                Route::delete('{id}', ['uses' => $namespacePrefix.'LogoincMenuController@delete_menu', 'as' => 'destroy']);
                Route::post('/', ['uses' => $namespacePrefix.'LogoincMenuController@add_item',    'as' => 'add']);
                Route::put('/', ['uses' => $namespacePrefix.'LogoincMenuController@update_item', 'as' => 'update']);
            });
        });
		
		

        // Settings
        Route::group([
            'as'     => 'settings.',
            'prefix' => 'settings',
        ], function () use ($namespacePrefix) {
            Route::get('/', ['uses' => $namespacePrefix.'LogoincSettingsController@index',        'as' => 'index']);
            Route::post('/', ['uses' => $namespacePrefix.'LogoincSettingsController@store',        'as' => 'store']);
            Route::put('/', ['uses' => $namespacePrefix.'LogoincSettingsController@update',       'as' => 'update']);
            Route::delete('{id}', ['uses' => $namespacePrefix.'LogoincSettingsController@delete',       'as' => 'delete']);
            Route::get('{id}/move_up', ['uses' => $namespacePrefix.'LogoincSettingsController@move_up',      'as' => 'move_up']);
            Route::get('{id}/move_down', ['uses' => $namespacePrefix.'LogoincSettingsController@move_down',    'as' => 'move_down']);
            Route::put('{id}/delete_value', ['uses' => $namespacePrefix.'LogoincSettingsController@delete_value', 'as' => 'delete_value']);
        });

        // Admin Media
        Route::group([
            'as'     => 'media.',
            'prefix' => 'media',
        ], function () use ($namespacePrefix) {
            Route::get('/', ['uses' => $namespacePrefix.'LogoincMediaController@index',              'as' => 'index']);
            Route::post('files', ['uses' => $namespacePrefix.'LogoincMediaController@files',              'as' => 'files']);
            Route::post('new_folder', ['uses' => $namespacePrefix.'LogoincMediaController@new_folder',         'as' => 'new_folder']);
            Route::post('delete_file_folder', ['uses' => $namespacePrefix.'LogoincMediaController@delete', 'as' => 'delete']);
            Route::post('move_file', ['uses' => $namespacePrefix.'LogoincMediaController@move',          'as' => 'move']);
            Route::post('rename_file', ['uses' => $namespacePrefix.'LogoincMediaController@rename',        'as' => 'rename']);
            Route::post('upload', ['uses' => $namespacePrefix.'LogoincMediaController@upload',             'as' => 'upload']);
            Route::post('crop', ['uses' => $namespacePrefix.'LogoincMediaController@crop',             'as' => 'crop']);
        });

        // BREAD Routes
        Route::group([
            'as'     => 'bread.',
            'prefix' => 'bread',
        ], function () use ($namespacePrefix) {
            Route::get('/', ['uses' => $namespacePrefix.'LogoincBreadController@index',              'as' => 'index']);
            Route::get('{table}/create', ['uses' => $namespacePrefix.'LogoincBreadController@create',     'as' => 'create']);
            Route::post('/', ['uses' => $namespacePrefix.'LogoincBreadController@store',   'as' => 'store']);
            Route::get('{table}/edit', ['uses' => $namespacePrefix.'LogoincBreadController@edit', 'as' => 'edit']);
            Route::put('{id}', ['uses' => $namespacePrefix.'LogoincBreadController@update',  'as' => 'update']);
            Route::delete('{id}', ['uses' => $namespacePrefix.'LogoincBreadController@destroy',  'as' => 'delete']);
            Route::post('relationship', ['uses' => $namespacePrefix.'LogoincBreadController@addRelationship',  'as' => 'relationship']);
            Route::get('delete_relationship/{id}', ['uses' => $namespacePrefix.'LogoincBreadController@deleteRelationship',  'as' => 'delete_relationship']);
        });

        // Database Routes
        Route::resource('database', $namespacePrefix.'LogoincDatabaseController');

        // Compass Routes
        Route::group([
            'as'     => 'compass.',
            'prefix' => 'compass',
        ], function () use ($namespacePrefix) {
            Route::get('/', ['uses' => $namespacePrefix.'LogoincCompassController@index',  'as' => 'index']);
            Route::post('/', ['uses' => $namespacePrefix.'LogoincCompassController@index',  'as' => 'post']);
        });

        event(new RoutingAdminAfter());
    });

    //Asset Routes
    Route::get('logoinc-assets', ['uses' => $namespacePrefix.'LogoincController@assets', 'as' => 'logoinc_assets']);

    event(new RoutingAfter());
});
