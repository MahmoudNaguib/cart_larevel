<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends BaseModel {

    use SoftDeletes,
        \App\Models\Traits\CreatedBy,
        \Spatie\Translatable\HasTranslations;

    public $translatable = ['title'];
    protected $table = "currencies";
    protected $guarded = [
        'deleted_at',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    public $rules = [
        'iso' => 'required|size:2',
        'title' => 'required',
        'rate' => 'required|numeric'
    ];

    public function toSearchableArray() {
        $array = [
            'id' => $this->id,
            'title' => $this->title,
        ];
        return $array;
    }

    public function getNameAttribute() {
        return @$this->getTranslation('title', lang()) . ' (' . @$this->attributes['iso'] . ')';
    }

    public function scopeFilterAndSort() {
        return $this->with(['creator'])
            ->when(request('created_by'), function ($q) {
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
                    'Short code' => $row->iso,
                    'Title' => @$row->title,
                    'Rate' => @$row->rate,
                    'Created at' => @$row->created_at,
                ];
            });
    }

}
