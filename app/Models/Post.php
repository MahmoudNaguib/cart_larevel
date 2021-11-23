<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends \App\Models\BaseModel {

    use SoftDeletes,
        \App\Models\Traits\CreatedBy,
        \App\Models\Traits\Sluggable,
        \App\Models\Traits\HasAttach,
        \Laravel\Scout\Searchable,
        \Spatie\Translatable\HasTranslations;

    ///////////////////////////// has translation
    public $translatable = ['title', 'slug', 'summary', 'content', 'tags', 'meta_description', 'meta_keywords'];
    protected $table = "posts";
    protected $guarded = [
        'deleted_at',
        'image',
    ];
    protected $attributes=[
        'is_active'=>1,
    ];
    protected $hidden = [
        'deleted_at',
    ];
    static $attachFields = [
        'image' => [
            'sizes' => ['large' => 'resize,400x240', 'small' => 'crop,200x120']
        ],
    ];
    public $rules = [
        'section_id'=>'required',
        'title' => 'required',
        'summary' => 'required',
        'content' => 'required',
        'image' => 'nullable|image|max:5000'
    ];
    protected $append = ['views', 'link'];

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
                \DB::table('posts')->where('id', $row->id)->update($data);
            }
        });
    }

    public function scopeActive($query) {
        return $query->where('is_active', '=', 1);
    }

    public function includes() {
        return $this->with(['section']);
    }

    public function scopeFilterAndSort() {
        return $this->includes()
            ->when(request('section_id'), function ($q) {
                return $q->where('section_id', request('section_id'));
            })
            ->when(request('created_by'), function ($q) {
                return $q->where('created_by', request('created_by'));
            })
            ->when(request('order_field'), function ($q) {
                return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
            })
            ->orderBy('id', 'desc');
    }

    public function section() {
        return $this->belongsTo(Section::class, 'section_id')->withTrashed()->withDefault();
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
            ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                return [
                    'ID' => $row->id,
                    'Section' => $row->section->title,
                    'Title' => $row->title,
                    'Summary' => $row->summary,
                    'Content' => $row->content,
                    'Tags' => $row->tags,
                    'Image' => $row->image,
                    'Is Active' => ($row->is_active) ? trans('app.Yes') : trans('app.No'),
                    'Created at' => @$row->created_at,
                ];
            });
    }

    public function getLinkAttribute() {
        return lang() . '/posts/details/' . $this->id . '/' . $this->slug;
    }

    public function getTitleLimitedAttribute() {
        return str_limit($this->title, 35);
    }

    public function getContentLimitedAttribute() {
        return str_limit(strip_tags($this->content), 60);
    }

    public function getTagsListAttribute() {
        return explode(',', $this->tags);
    }

}
