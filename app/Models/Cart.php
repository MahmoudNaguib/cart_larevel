<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends \App\Models\BaseModel {

    use SoftDeletes,
        \App\Models\Traits\CreatedBy;

    ///////////////////////////// has translation
    protected $table = "cart";
    protected $guarded = [
        'deleted_at',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    public $rules = [
        'product_id' => 'required|integer|exists:products,id',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed()->withDefault();
    }

    public function scopeOwn($query) {
        return $query->where('created_by', auth()->user()->id);
    }

    public function includes() {
        return $this->with(['product']);
    }

    public function scopeFilterAndSort() {
        return $this->includes()
            ->when(request('created_by'), function ($q) {
                return $q->where('created_by', request('created_by'));
            })
            ->when(request('product_id'), function ($q) {
                return $q->where('product_id', request('product_id'));
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
                    'Product' => $row->product->title,
                    'Quantity' => $row->quantity,
                    'Created at' => @$row->created_at,
                ];
            });
    }

}
