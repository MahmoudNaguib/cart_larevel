<?php

namespace App\Models\Traits;

use DB;

trait Sluggable {

    public static function bootSluggable() {
        static::saved(function ($model) {
            if (!$model->slug) {
                $slugTitle = (isset(static::$slugTitle)) ? static::$slugTitle : 'title';
                if (count(langs()) < 2) {
                    $slug = slug(request($slugTitle));
                } else {
                    foreach (langs() as $lang) {
                        $slug[$lang] = slug(request($slugTitle . '.' . $lang));
                    }
                    $slug = json_encode($slug);
                }
                DB::table($model->table)->where('id', $model->id)->update(['slug' => $slug]);
            }
            
        });
    }

}
