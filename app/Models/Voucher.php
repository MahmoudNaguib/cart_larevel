<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends BaseModel {

    use SoftDeletes,
        \App\Models\Traits\CreatedBy;

    protected $table = "vouchers";
    protected $guarded = [
        'deleted_at',
        'image',
    ];
    protected $attributes=[
        'max_usage'=>1,
        'amount'=>1,
    ];
    protected $hidden = [
        'deleted_at',
    ];
    public $rules = [
        'amount' => 'required',
        'expiry_date' => 'required|date'
    ];
    protected $append = ['value_local'];

    public function toSearchableArray() {
        $array = [
            'id' => $this->id,
            'code' => $this->code,
        ];
        return $array;
    }

    public static function boot() {
        parent::boot();
        static::created(function ($row) {
            if (!request('code') && !$row->code) {
                \DB::table('vouchers')->where('id', $row->id)->update(['code' => RandomString(5)]);
            }
        });
    }

    public function getValueLocalAttribute() {
        return changeRate($this->value, userCurrency()->id, $this->currency_id);
    }
    public function includes() {
        return $this->with(['currency']);
    }
    public function scopeFilterAndSort() {
        return $this->includes()
                        ->when(request('created_by'), function($q) {
                            return $q->where('created_by', request('created_by'));
                        })
                        ->when(request('order_field'), function ($q) {
                            return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
                        })
                        ->orderBy('id', 'desc');
    }

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id')->withTrashed()->withDefault();
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
                        ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                            return [
                                'ID' => $row->id,
                                'Code' => $row->code,
                                'Value' => $row->value.' '.$row->currency->iso,
                                'Expiry date' => $row->expiry_date,
                                'Max usage' => $row->max_usage,
                                'Used' => $row->used,
                                'Created at' => @$row->created_at,
                            ];
                        });
    }

}
