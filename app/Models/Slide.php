<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends \App\Models\BaseModel {

    use SoftDeletes,
        \App\Models\Traits\CreatedBy,
        \App\Models\Traits\HasAttach,
        \Laravel\Scout\Searchable,
        \Spatie\Translatable\HasTranslations;

    ///////////////////////////// has translation
    public $translatable = ['title', 'content'];
    protected $table = "slides";
    protected $guarded = [
        'deleted_at',
        'image',
    ];
    protected $attributes=[
        'is_active'=>1
    ];
    protected $hidden = [
        'deleted_at',
    ];
    static $attachFields = [
        'image' => [
            'sizes' => ['large' => 'crop,1350x390','small' => 'resize,200x120']
        ],
    ];
    public $rules = [
        'title' => 'required',
        'content' => 'required',
        'url' => 'required|url',
        'image' => 'nullable|image|max:5000'
    ];

    public function toSearchableArray() {
        $array = [
            'id' => $this->id,
            'title' => $this->title,
        ];
        return $array;
    }

    public static function boot() {
        parent::boot();
        static::created(function ($row) {
            if (!request()->hasFile('image') && !$row->image) {
                $image = generateImage($row->title, static::$attachFields['image']['sizes']);
                $data['image'] = $image;
                \DB::table('slides')->where('id', $row->id)->update($data);
            }
        });
    }

    public function scopeActive($query) {
        return $query->where('is_active', '=', 1);
    }

    public function scopeFilterAndSort() {
        return $this->when(request('created_by'), function ($q) {
            return $q->where('created_by', request('created_by'));
        })
            ->when(request('order_field'), function ($q) {
                return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
            })
            ->orderBy('id', 'desc');
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
            ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                return [
                    'ID' => $row->id,
                    'Title' => $row->title,
                    'Content' => $row->content,
                    'URL' => $row->url,
                    'Image' => $row->image,
                    'Created at' => @$row->created_at,
                ];
            });
    }

    public function getTitleLimitedAttribute() {
        return str_limit($this->title, 35);
    }

    public function getContentLimitedAttribute() {
        return str_limit(strip_tags($this->content), 60);
    }

}
