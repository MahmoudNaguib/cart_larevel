<?php

namespace App\Models;

class Config extends BaseModel {

    use \App\Models\Traits\CreatedBy;

    protected $table = "configs";
    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $rules = [
        'type' => 'required',
        'field' => 'required',
    ];

    public function scopeFilterAndSort() {
        return $this->with(['creator'])
                        ->when(request('created_by'), function($q) {
                            return $q->where('created_by', request('created_by'));
                        })
                        ->when(request('order_field'), function ($q) {
                            return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
                        })
                        ->orderBy('id', 'desc');
    }

}
