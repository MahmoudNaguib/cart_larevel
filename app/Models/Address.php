<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends BaseModel {

    use SoftDeletes,
        \App\Models\Traits\CreatedBy;

    protected $table = "addresses";
    protected $guarded = [
        'deleted_at',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    public $rules = [
        'title'=>'required',
        'country_id' => 'required',
        'city' => 'required',
        'district' => 'required',
        'zip_code' => 'required',
        'address' => 'required',
    ];
    protected $append = ['full_address'];

    public function toSearchableArray() {
        $array = [
            'id' => $this->id,
            'city' => $this->city,
            'district' => $this->district,
            'zip_code' => $this->zip_code,
        ];
        return $array;
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_id')->withDefault();
    }

    public function scopeOwn($query) {
        return $query->where('created_by', auth()->user()->id);
    }

    public function includes() {
        return $this->with(['country']);
    }

    public function scopeFilterAndSort() {
        return $this->includes()
            ->when(request('created_by'), function ($q) {
                return $q->where('created_by', request('created_by'));
            })
            ->when(request('country_id'), function ($q) {
                return $q->where('country_id', request('country_id'));
            })
            ->when(request('order_field'), function ($q) {
                return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
            })
            ->orderBy('id', 'desc');
    }

    public function getFullAddressAttribute() {
        return '('.$this->title.') '.$this->address . ', '.$this->country->title.', '. $this->city . ', ' . $this->district . ', ' . trans('app.Zip code') . '(' . $this->zip_code . ')' . ' ' . $this->notes;
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
            ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                return [
                    'ID' => $row->id,
                    'title' => $row->title,
                    'Country' => $row->country->title,
                    'City' => $row->city,
                    'District' => @$row->district,
                    'Zip code' => $row->zip_code,
                    'Created at' => @$row->created_at,
                ];
            });
    }

}
