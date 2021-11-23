<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel {

    use SoftDeletes,
        \App\Models\Traits\CreatedBy,
        \App\Models\Traits\HasAttach,
        \Spatie\Translatable\HasTranslations;

    public $translatable = ['title'];
    protected $table = "categories";
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
    public $rules = [
        'title' => 'required',
        'image' => 'nullable|image|max:5000'
    ];
    static $attachFields = [
        'image' => [
            'sizes' => ['large' => 'resize,400x240', 'small' => 'crop,200x120']
        ],
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
                \DB::table('categories')->where('id', $row->id)->update($data);
            }
        });
    }

    public static function getCategoriesWithTop() {
        $mainCategories = \App\Models\Category::with(['childs'])->where('top_id', null)->active()->get();
        $rows = [];
        if ($mainCategories) {
            foreach ($mainCategories as $mainCategory) {
                $subCategories = $mainCategory->childs()->get();
                $subCats=[];
                if($subCategories){
                    foreach($subCategories as $sub){
                        $subCats[$sub->id]=$sub->title;
                    }
                }
                $rows[$mainCategory->id] = [
                    'title' => $mainCategory->title,
                    'childs' => $subCats
                ];
            }
        }
        return $rows;
    }

    public function top() {
        return $this->belongsTo(Category::class, 'top_id')->withTrashed()->withDefault();
    }

    public function childs() {
        return $this->hasMany(Category::class, 'top_id');
    }

    public function includes() {
        return $this;
    }

    public function scopeFilterAndSort() {
        return $this->includes()
            ->when(request('created_by'), function ($q) {
                return $q->where('created_by', request('created_by'));
            })
            ->when(request('top_id'), function ($q) {
                return $q->where('top_id', request('top_id'));
            })
            ->when(request('order_field'), function ($q) {
                return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
            })
            ->orderBy('id', 'desc');
    }

    public function scopeActive($query) {
        return $query->where('is_active', '=', 1);
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
            ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                return [
                    'ID' => $row->id,
                    'Main category' => ($row->top->title)?:'------',
                    'Title' => $row->title,
                    'Created at' => @$row->created_at,
                ];
            });
    }

}
