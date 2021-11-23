<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use SoftDeletes,
        \App\Models\Traits\CreatedBy,
        \Laravel\Scout\Searchable,
        \App\Models\Traits\HasAttach;

    protected $attributes = [
        'confirmed' => 1,
    ];
    protected $table = "users";
    protected $guarded = [
        'deleted_at',
        'image',
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'confirm_token',
        'confirmed',
        'is_active',
        'created_by',
        'updated_at',
        'deleted_at',
    ];
    static $attachFields = [
        'image' => [
            'sizes' => ['large' => 'resize,400x240', 'small' => 'crop,200x120']
        ],
    ];
    public $adminCreateRules = [
        'name' => 'required|min:4',
        'email' => 'required|email|unique:users,email',
        'mobile' => 'required|mobile',
        'password' => 'required|confirmed|min:8',
        'image' => 'nullable|image|max:5000',
        'country_id' => 'required|exists:countries,id',
        'currency_id' => 'required|exists:currencies,id',
        'language' => 'required|in:en,ar',
    ];
    public $adminEditRules = [
        'name' => 'required|min:4',
        'email' => 'required|email|unique:users,email',
        'mobile' => 'required|mobile',
        'password' => 'nullable|confirmed|min:8',
        'image' => 'nullable|image|max:5000',
        'country_id' => 'required|exists:countries,id',
        'currency_id' => 'required|exists:currencies,id',
        'language' => 'required|in:en,ar',
    ];
    public $registerRules = [
        'name' => 'required|min:4',
        'email' => 'required|email|unique:users,email',
        'mobile' => 'required|mobile',
        'password' => 'required|confirmed|min:8',
    ];
    public $editProfileRules = [
        'country_id' => 'required|exists:countries,id',
        'currency_id' => 'required|exists:currencies,id',
        'language' => 'required|in:en,ar',
        'name' => 'required|min:4',
        //'email' => 'required|email|unique:users,email',
        'mobile' => 'required|mobile',
        'image' => 'nullable|image|max:5000'
    ];
    public $loginRules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
        'push_token' => 'nullable|min:8',
    ];
    public $forgotRules = [
        'email' => 'required|email',
    ];
    public $changePasswordRules = [
        'old_password' => 'required|min:8',
        'password' => 'required|confirmed|min:8',
    ];
    public $changeImageRules = [
        'image' => 'required|image|max:5000'
    ];
    protected $appends = [];

    public function toSearchableArray() {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
        ];
        return $array;
    }

    public static function boot() {
        parent::boot();
        static::created(function ($row) {
            if (!request()->hasFile('image') && !$row->image) {
                $image = generateImage($row->name, static::$attachFields['image']['sizes']);
                \DB::table('users')->where('id', $row->id)->update([
                    'image' => $image,
                    'confirm_token' => md5(time()) . md5($row->name) . md5(rand(1000, 10000)),
                ]);
            }
            if (!app()->environment('testing')) {
                \App\Jobs\UserCreated::dispatch($row);
            }
        });
    }

    public static function getLanguages() {
        return [
            'en' => trans('app.English'),
            'ar' => trans('app.Arabic'),
        ];
    }

    public function getCountries() {
        return \App\Models\Country::pluck('title', 'id');
    }

    public function getCurrencies() {
        return \App\Models\Currency::pluck('title', 'id');
    }

    public function getRoles() {
        return \App\Models\Role::where('id', '>', 1)->pluck('title', 'id');
    }

    public function role() {
        return $this->belongsTo(Role::class, 'role_id')->withDefault();
    }

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id')->withDefault();
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_id')->withDefault();
    }

    public function includes() {
        return $this->with(['role', 'currency', 'country']);
    }

    public function scopeFilterAndSort() {
        return $this->includes()
            ->when(request('created_by'), function ($q) {
                return $q->where('created_by', request('created_by'));
            })
            ->when(request('currency_id'), function ($q) {
                return $q->where('currency_id', request('currency_id'));
            })
            ->when(request('country_id'), function ($q) {
                return $q->where('country_id', request('country_id'));
            })
            ->when(request('language'), function ($q) {
                return $q->where('language', request('language'));
            })
            ->when(request('name'), function ($q) {
                return $q->where('name', 'LIKE', '%' . request('name') . '%');
            })
            ->when(request('email'), function ($q) {
                return $q->where('email', 'LIKE', '%' . request('email') . '%');
            })
            ->when(request('mobile'), function ($q) {
                return $q->where('mobile', 'LIKE', '%' . request('mobile') . '%');
            })
            ->notSuperAdmin()
            ->when(request('order_field'), function ($q) {
                return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
            })
            ->orderBy('id', 'desc');
    }

    public function scopeActive($query) {
        return $query->where('is_active', '=', 1)->where('confirmed', 1);
    }

    public function scopeAdmin($query) {
        return $query->where('role_id', '!=', NULL);
    }

    public function scopeNotSuperAdmin($query) {
        return $query->where(function ($q) {
            return $q->where('role_id', '!=', 1)
                ->orWhere('role_id', NULL);
        });
    }

    public function getIsAdminAttribute() {
        return ($this->role_id);
    }

    public function getIsSuperAdminAttribute() {
        return ($this->role_id == 1);
    }

    public function notifications() {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function addresses() {
        return $this->hasMany(Address::class, 'created_by');
    }

    public function tokens() {
        return $this->hasMany(Token::class);
    }

    public function setPasswordAttribute($value) {
        if (trim($value)) {
            $this->attributes['password'] = bcrypt(trim($value));
        }
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
            ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                return [
                    'ID' => $row->id,
                    'Role' => ($row->role->title) ?: trans('admin.Guest'),
                    'Full name' => $row->name,
                    'Email' => $row->email,
                    'Mobile' => $row->mobile,
                    'Country' => $row->country->title,
                    'Currency' => $row->currency->title,
                    'Language' => $row->language,
                    'Created at' => @$row->created_at,
                ];
            });
    }

}
