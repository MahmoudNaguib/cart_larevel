<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends BaseModel {

    use SoftDeletes,
        \Laravel\Scout\Searchable;

    protected $table = "contacts";
    protected $guarded = [
        'deleted_at',
        'g-recaptcha-response'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    public $rules = [
        'email' => 'required|email',
    ];

    public static function boot() {
        parent::boot();
        static::created(function ($row) {
           // \App\Jobs\ContactCreated::dispatch($row);
        });
    }

    public function toSearchableArray() {
        $array = [
            'id' => $this->id,
            'email' => $this->email,
        ];
        return $array;
    }

    public function scopeFilterAndSort() {
        return $this->when(request('order_field'), function ($q) {
            return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
        })
            ->orderBy('id', 'desc');
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
            ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                return [
                    'ID' => $row->id,
                    'Email' => $row->email,
                    'Created at' => @$row->created_at,
                ];
            });
    }

}
