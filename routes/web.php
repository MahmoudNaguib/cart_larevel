<?php
/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

//Route::get('/', function () {
//    return view('welcome');
//});


Route::group(['prefix' => (app()->environment() == 'testing') ? 'en' : LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function() {
    AdvancedRoute::controller('auth', 'AuthController');
    Route::group(['middleware' => ['auth']], function() {
        Route::group(['middleware' => ['IsAdmin'], 'prefix' => 'admin'], function() {
            AdvancedRoute::controller('profile', 'Admin\ProfileController');
            AdvancedRoute::controller('notifications', 'Admin\NotificationsController');
            AdvancedRoute::controller('dashboard', 'Admin\DashBoardController');

            AdvancedRoute::controller('products', 'Admin\ProductsController');
            AdvancedRoute::controller('categories', 'Admin\CategoriesController');

            AdvancedRoute::controller('posts', 'Admin\PostsController');
            AdvancedRoute::controller('sections', 'Admin\SectionsController');

            AdvancedRoute::controller('translator', 'Admin\TranslatorController');
            AdvancedRoute::controller('countries', 'Admin\CountriesController');
            AdvancedRoute::controller('roles', 'Admin\RolesController');
            AdvancedRoute::controller('users', 'Admin\UsersController');
            AdvancedRoute::controller('configs', 'Admin\ConfigsController');

            AdvancedRoute::controller('slides', 'Admin\SlidesController');
            AdvancedRoute::controller('contacts', 'Admin\ContactsController');
            AdvancedRoute::controller('messages', 'Admin\MessagesController');
            AdvancedRoute::controller('pages', 'Admin\PagesController');
            AdvancedRoute::controller('search', 'Admin\SearchController');


            AdvancedRoute::controller('orders', 'Admin\OrdersController');

            AdvancedRoute::controller('currencies', 'Admin\CurrenciesController');
            AdvancedRoute::controller('reviews', 'Admin\ReviewsController');
            AdvancedRoute::controller('vouchers', 'Admin\VouchersController');
        });
    });
    Route::get('/', function() {
        return redirect('auth/login');
    });
    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index']);


});



//Route::prefix('api')->group(function () {
//    require_once __DIR__ . '/api.php';
//});
