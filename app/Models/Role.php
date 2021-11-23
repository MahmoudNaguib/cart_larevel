<?php

namespace App\Models;

class Role extends BaseModel {

    use \App\Models\Traits\CreatedBy;

    protected $table = "roles";
    protected $guarded = [
        'deleted_at',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    public $rules = ['title' => 'required|unique:roles,title', 'permissions' => 'required'];

    public function getPermissionsAttribute($value) {
        return json_decode($value);
    }

    public function setPermissionsAttribute($value) {
        if ($value) {
            $this->attributes['permissions'] = json_encode($value);
        }
    }

    public function scopeFilterAndSort() {
        return $this->where('id', '>', 1)
                        ->when(request('created_by'), function($q) {
                            return $q->where('created_by', request('created_by'));
                        })
                        ->when(request('order_field'), function ($q) {
                            return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
                        })
                        ->orderBy('id','desc');
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
                        ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                            return [
                                'ID' => $row->id,
                                'Title' => $row->title,
                                'Permission' => @implode(', ', (@$row->permissions) ?: []),
                                'Created at' => @$row->created_at,
                            ];
                        });
    }

}
