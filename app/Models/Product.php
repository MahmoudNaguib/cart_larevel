<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends \App\Models\BaseModel {

    use SoftDeletes,
        \App\Models\Traits\CreatedBy,
        \App\Models\Traits\FinalPrice,
        \App\Models\Traits\Sluggable,
        \App\Models\Traits\HasAttach,
        \Laravel\Scout\Searchable,
        \Spatie\Translatable\HasTranslations;

    ///////////////////////////// has translation
    public $translatable = ['title', 'slug', 'summary', 'content', 'tags', 'meta_description', 'meta_keywords'];
    protected $table = "products";
    protected $guarded = [
        'deleted_at',
        'image',
    ];
    protected $attributes=[
        'is_active'=>1,
        'price'=>0,
        'discount'=>0
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
        'category_id' => 'required',
        'title' => 'required',
        'summary' => 'required',
        'content' => 'required',
        'price' => 'required|numeric',
        'discount' => 'required|numeric',
        'image' => 'nullable|image|max:5000'
    ];
    protected $append = ['views', 'link', 'price_local', 'price_with_user_currency', 'final_price_with_user_currency', 'discount_with_user_currency'];

    public function toSearchableArray() {
        $array = [
            'id' => $this->id,
            'title' => $this->title,
        ];
        return $array;
    }

    public function getPriceLocalAttribute() {
        return changeRate($this->price, userCurrency()->id, $this->currency_id);
    }

    public function getFinalPriceLocalAttribute() {
        return changeRate($this->final_price, userCurrency()->id, $this->currency_id);
    }

    public static function boot() {
        parent::boot();
        static::created(function ($row) {
            if (!request()->hasFile('image') && !$row->image) {
                $image = generateImage($row->title, static::$attachFields['image']['sizes']);
                $data['image'] = $image;
                \DB::table('products')->where('id', $row->id)->update($data);
            }
        });
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function Category() {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed()->withDefault();
    }

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id')->withTrashed()->withDefault();
    }

    public function scopeActive($query) {
        return $query->where('is_active', '=', 1);
    }

    public function includes() {
        return $this->with(['category', 'currency']);
    }

    public function scopeFilterAndSort() {
        return $this->includes()
            ->when(request('category_id'), function ($q) {
                return $q->where('category_id', request('category_id'));
            })
            ->when(request('currency_id'), function ($q) {
                return $q->where('currency_id', request('currency_id'));
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
                    'Category' => $row->category->title,
                    'Title' => $row->title,
                    'Summary' => $row->summary,
                    'Content' => $row->content,
                    'Price' => $row->price,
                    'Discount' => $row->dicsount,
                    'Tags' => $row->tags,
                    'Image' => $row->image,
                    'Is Active' => ($row->is_active) ? trans('app.Yes') : trans('app.No'),
                    'Created at' => @$row->created_at,
                ];
            });
    }

    public function getLinkAttribute() {
        return lang() . '/products/details/' . $this->id . '/' . $this->slug;
    }

    public function getTitleLimitedAttribute() {
        return str_limit($this->title, 35);
    }

    public function getContentLimitedAttribute() {
        return str_limit(strip_tags($this->content), 60);
    }

    public function getPriceWithUserCurrencyAttribute() {
        return changeRate($this->price, userCurrency()->id, $this->currency_id);
    }

    public function getFinalPriceWithUserCurrencyAttribute() {
        return changeRate($this->final_price, userCurrency()->id, $this->currency_id);
    }

    public function getDiscountWithUserCurrencyAttribute() {
        return changeRate($this->discount, userCurrency()->id, $this->currency_id);
    }

}
