<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PushToken extends BaseModel {
    use \App\Models\Traits\CreatedBy;

    protected $table = "push_tokens";
    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $rules = [
        'token' => 'required',
    ];

}
