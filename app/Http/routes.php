<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/* Frontend Zone */
Route::get('/', [
	'as' => 'index', 
	'uses' => 'front\HomeController@index'
]);

/* User Zone */
Route::group(['prefix' => 'back/user/'], function(){
	/* Authenticate Zone */
	Route::get('', [
		'as' => 'backUserIndex', 
		'uses' => 'back\user\HomeController@index'
		]);
	Route::get('login', [
		'as' => 'backUserLoginForm', 
		'uses' => 'back\user\LoginController@index'
		]);
	Route::post('login', [
		'as' => 'backUserAuthen',
		'uses' => 'back\user\LoginController@authenticate'
		]);
	Route::get('logout', [
		'as' => 'backUserLogout', 
		'uses' => 'back\user\LoginController@logout'
		]);

	/* Command Zone */
	Route::get('command', [
		'as' => 'backUserCommand', 
		'uses' => 'back\user\PiController@piCommand'
		]);

	Route::group(['prefix' => 'area/'], function(){
		/* Area Zone */
		Route::get('', [
			'as' => 'backUserArea', 
			'uses' => 'back\user\AreaController@index'
			]);
	});

	Route::group(['prefix' => 'device/'], function(){
		/* Area Zone */
		Route::get('', [
			'as' => 'backUserDevice', 
			'uses' => 'back\user\DeviceController@index'
			]);
		Route::get('info', [
			'as' => 'backUserDeviceInfo', 
			'uses' => 'back\user\DeviceController@info'
			]);
		Route::post('set_value', [
			'as' => 'backUserDeviceSetValue', 
			'uses' => 'back\user\DeviceController@setValue'
			]);
	});

	Route::group(['prefix' => 'scene/'], function(){
		/* Area Zone */
		Route::get('', [
			'as' => 'backUserScene', 
			'uses' => 'back\user\SceneController@index'
			]);
		Route::post('apply_scene', [
			'as' => 'backUserSceneApplyScene', 
			'uses' => 'back\user\SceneController@applyScene'
			]);
	});
});



/* Manage Zone */
Route::group(['prefix' => 'back/manage/'], function(){
	/* Authenticate Zone */
	Route::get('', [
		'as' => 'backManageIndex', 
		'uses' => 'back\manage\HomeController@index'
		]);
	Route::get('login', [
		'as' => 'backManageLoginForm',
		'uses' => 'back\manage\LoginController@index'
		]);
	Route::post('login', [
		'as' => 'backManageAuthen', 
		'uses' => 'back\manage\LoginController@authenticate'
		]);
	Route::get('logout', [
		'as' => 'backManageLogout', 
		'uses' => 'back\manage\LoginController@logout'
		]);
		
	Route::group(['prefix' => 'user/'], function(){
		/* User Zone */
		Route::get('profile', [
			'as' => 'backManageProfile', 
			'uses' => 'back\manage\UserController@profile'
			]);
		Route::post('edit_profile', [
			'as' => 'backManageEditProfile', 
			'uses' => 'back\manage\UserController@editProfile'
			]);
		Route::post('edit_password', [
			'as' => 'backManageEditPassword', 
			'uses' => 'back\manage\UserController@editPassword'
			]);

		Route::get('', [
			'as' => 'backManageUser', 
			'uses' => 'back\manage\UserController@index'
			]);
		Route::get('obj', [
			'as' => 'backManageUserObj', 
			'uses' => 'back\manage\UserController@obj'
			]);
		Route::post('add', [
			'as' => 'backManageUserAdd', 
			'uses' => 'back\manage\UserController@add'
			]);
		Route::post('edit', [
			'as' => 'backManageUserEdit', 
			'uses' => 'back\manage\UserController@edit'
			]);
		Route::post('remove', [
			'as' => 'backManageUserRemove', 
			'uses' => 'back\manage\UserController@remove'
			]);
	});

	Route::group(['prefix' => 'area/'], function(){
		/* Area Zone */
		Route::get('', [
			'as' => 'backManageArea', 
			'uses' => 'back\manage\AreaController@index'
			]);
		Route::get('obj', [
			'as' => 'backManageAreaObj', 
			'uses' => 'back\manage\AreaController@obj'
			]);
		Route::post('add', [
			'as' => 'backManageAreaAdd', 
			'uses' => 'back\manage\AreaController@add'
			]);
		Route::post('edit', [
			'as' => 'backManageAreaEdit', 
			'uses' => 'back\manage\AreaController@edit'
			]);
		Route::post('remove', [
			'as' => 'backManageAreaRemove', 
			'uses' => 'back\manage\AreaController@remove'
			]);
	});

	Route::group(['prefix' => 'device/'], function(){
		/* Device Zone */
		Route::get('', [
			'as' => 'backManageDevice', 
			'uses' => 'back\manage\DeviceController@index'
			]);
		Route::get('obj', [
			'as' => 'backManageDeviceObj', 
			'uses' => 'back\manage\DeviceController@obj'
			]);
		Route::post('add', [
			'as' => 'backManageDeviceAdd', 
			'uses' => 'back\manage\DeviceController@add'
			]);
		Route::post('edit', [
			'as' => 'backManageDeviceEdit', 
			'uses' => 'back\manage\DeviceController@edit'
			]);
		Route::post('remove', [
			'as' => 'backManageDeviceRemove', 
			'uses' => 'back\manage\DeviceController@remove'
			]);
	});

	Route::group(['prefix' => 'scene/'], function(){
		/* Scene Zone */
		Route::get('', [
			'as' => 'backManageScene', 
			'uses' => 'back\manage\SceneController@index'
			]);
		Route::get('obj', [
			'as' => 'backManageSceneObj', 
			'uses' => 'back\manage\SceneController@obj'
			]);
		Route::post('add', [
			'as' => 'backManageSceneAdd', 
			'uses' => 'back\manage\SceneController@add'
			]);
		Route::post('edit', [
			'as' => 'backManageSceneEdit', 
			'uses' => 'back\manage\SceneController@edit'
			]);
		Route::post('remove', [
			'as' => 'backManageSceneRemove', 
			'uses' => 'back\manage\SceneController@remove'
			]);
	});
	
});