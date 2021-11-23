<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends BaseModel {

    use SoftDeletes;

    protected $table = "notifications";
    protected $guarded = [
        'deleted_at',
        'logged_user',
    ];
    protected $hidden = [
        'deleted_at',
    ];

    public static function boot() {
        parent::boot();
        static::created(function ($row) {
            \App\Jobs\NotificationCreated::dispatch($row);
        });
    }

    public function scopeFilterAndSort() {
        return $this->when(request('new'), function ($q) {
                            return $query->where('seen_at', NULl);
                        })->when(request('order_field'), function ($q) {
                            return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
                        })
                        ->orderBy('id', 'desc');
    }

    public function scopeOwn($query) {
        return $query->where('user_id', auth()->user()->id);
    }

    public function to() {
        return $this->belongsTo(User::class, 'user_id')->withTrashed()->withDefault();
    }

    public function scopeUnreaded($query) {
        return $query->where('seen_at', NULl);
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
                        ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                            return [
                                'ID' => $row->id,
                                'Title' => @$row->title,
                                'Content' => @$row->content,
                                'Url' => @$row->url,
                                'Seen at' => @$row->seen_at,
                                'Created at' => @$row->created_at,
                            ];
                        });
    }

}
