<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends BaseModel {

    use SoftDeletes,
        \Laravel\Scout\Searchable;

    protected $table = "messages";
    protected $guarded = [
        'deleted_at',
        'g-recaptcha-response',
        'captcha'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    public $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'content' => 'required',
    ];

    public static function boot() {
        parent::boot();
        static::created(function ($row) {
            //\App\Jobs\MessageCreated::dispatch($row);
        });
    }

    public function toSearchableArray() {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
        return $array;
    }

    public function scopeFilterAndSort() {
        return $this->when(request('order_field'), function ($q) {
                            return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
                        })
                        ->orderBy('id','desc');
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
                        ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                            return [
                                'ID' => $row->id,
                                'Name' => $row->name,
                                'Email' => @$row->email,
                                'Content' => @$row->content,
                                'Created at' => @$row->created_at,
                            ];
                        });
    }

}
