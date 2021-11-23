<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Form;
use Validator;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(190);

        Form::macro('rawLabel', function ($name, $value = null, $options = array()) {
            $label = Form::label($name, '%s', $options);
            return sprintf($label, $value);
        });
        /// validation rules
        Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
            if ($value == '') {
                return true;
            }
            if (!trim($value) && intval($value) != 0) {
                return true;
            }
            return (preg_match('/^([(+)0-9,\\-,+,]){4,20}$/', $value));
        });

//        if (!$this->app->environment('local')) {
//            $this->app['request']->server->set('HTTPS', 'on');
//        }
       // JsonResource::withoutWrapping();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
