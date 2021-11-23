<?php

namespace App\Models\Traits;

use DB;

trait FinalPrice {

    public static function bootFinalPrice() {
        static::saved(function ($model) {
            $finalPrice = $model->price - $model->discount;
            $finalPriceLocal = changeRate($finalPrice, env('DEFAULT_CURRENCY', 1), $model->currency_id);
            \DB::table($model->table)->where('id', $model->id)->update(['final_price' => $finalPrice, 'final_price_local' => $finalPriceLocal]);
        });
    }

}
