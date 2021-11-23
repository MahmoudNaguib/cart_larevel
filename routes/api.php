<?php
Route::group(['prefix' => (app()->environment() == 'testing') ? 'en' : setlang()], function () {
    Route::resource('configs', 'Api\ConfigsController');
    Route::resource('main', 'Api\MainController');
    AdvancedRoute::controller('auth', 'Api\AuthController');
    Route::group(['prefix' => 'admin','middleware' => ['ApiAuth']], function () {
        Route::group(['middleware' => ['ApiAdminAuth']], function () {
            Route::resource('countries', 'Api\Admin\AdminCountriesController');
        });
    });
    Route::resource('products', 'Api\ProductsController');
    Route::resource('posts', 'Api\PostsController');
    Route::resource('messages', 'Api\MessagesController');
    Route::resource('contacts', 'Api\ContactsController');
    Route::group(['middleware' => ['ApiAuth']], function () {
        AdvancedRoute::controller('profile', 'Api\Logged\LoggedProfileController');
        Route::get('addresses/pairs', 'Api\Logged\LoggedAddressesController@pairs');
        Route::resource('addresses', 'Api\Logged\LoggedAddressesController');
        Route::resource('notifications', 'Api\Logged\LoggedNotificationsController');
        Route::resource('favourites', 'Api\Logged\LoggedFavouritesController');
        Route::resource('cart', 'Api\Logged\LoggedCartController');
        Route::resource('reviews', 'Api\Logged\LoggedReviewsController');
        Route::resource('orders', 'Api\Logged\LoggedOrdersController');
    });
});

