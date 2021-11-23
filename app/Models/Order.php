<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends \App\Models\BaseModel {

    use SoftDeletes,
        \App\Models\Traits\CreatedBy;

    ///////////////////////////// has translation
    protected $table = "orders";
    protected $guarded = [
        'deleted_at',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    public $rules = [
        'address_id' => 'required|integer|exists:addresses,id',
    ];
    public $changeStatusRules = [
        'status' => 'required|in:Pending,Confirmed,Cancelled,In-Progress,In-Shipment,Delivered,Returned',
    ];
    protected $append = ['products_list'];

    public static function boot() {
        parent::boot();
        static::created(function ($row) {
            \App\Jobs\OrderCreated::dispatch($row);
        });
        static::updated(function ($row) {
            \App\Jobs\OrderStatusChanged::dispatch($row);
        });
    }

    public function address() {
        return $this->belongsTo(Address::class, 'address_id')->withTrashed()->withDefault();
    }

    public function voucher() {
        return $this->belongsTo(Voucher::class, 'voucher_id')->withTrashed()->withDefault();
    }

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id')->withTrashed()->withDefault();
    }

    public function scopeOwn($query) {
        return $query->where('created_by', auth()->user()->id);
    }

    public function createOrder($user, $others = []) {
        $cart = \App\Models\Cart::with(['product'])->where('created_by', $user->id)->get();
        $sum = 0;
        if ($cart) {
            if (isset($others['address_id']))
                $address = \App\Models\Address::where('created_by', $user->id)->find($others['address_id']);
            if (!isset($address))
                $address = \App\Models\Address::where('created_by', $user->id)->first();

            if (isset($others['voucher_code']))
                $voucher = \App\Models\Voucher::where('expiry_date', '>=', date('Y-m-d'))->where('max_usage', '>=', 'used')->where('code', $others['voucher_code'])->first();
            foreach ($cart as $row) {
                $productPrice = changeRate($row->product->final_price, userCurrency()->id, $row->product->currency_id);
                $rowPrice = $row->quantity * $productPrice;
                $sum = $sum + $rowPrice;
                $products[] = [
                    'product_id' => $row->product_id,
                    'product_title' => $row->product->title,
                    'product_image' => $row->product->image,
                    'currency_id' => userCurrency()->id,
                    'currency' => $row->product->currency->title,
                    'category_id' => $row->product->category_id,
                    'category' => $row->product->category->title,
                    'quantity' => $row->quantity,
                    'price' => (string) $productPrice,
                    'total' =>(string) $rowPrice,
                ];
            }

            if ($products) {
                $orderData = [
                    'address_id' => $address->id,
                    'full_address' => $address->full_address,
                    'contact_name' => (request('contact_name')) ?: $user->name,
                    'contact_mobile' => (request('contact_mobile')) ?: $user->mobile,
                    'products' => json_encode($products),
                    'sub_total' => $sum,
                    'currency_id' => userCurrency()->id,
                    'sub_total_local' => changeRate($sum, defaultCurrency()->id, userCurrency()->id),
                    'status' => env('DEFAULT_ORDER_STATUS', 'Confirmed'),
                    'created_by' => $user->id
                ];

                $orderData['voucher_id'] = (isset($voucher)) ? $voucher->id : NULL;
                $voucherAmount = (isset($voucher)) ? changeRate($voucher->amount, userCurrency()->id, $voucher->currency_id) : 0;
                $orderData['voucher_amount'] = $voucherAmount;
                $orderData['total'] = $sum - $voucherAmount;
                $orderData['total_local'] = changeRate($orderData['total'], defaultCurrency()->id, userCurrency()->id);
                $order = \App\Models\Order::create($orderData);
                \App\Models\Cart::where('created_by', $user->id)->delete();
                if (isset($voucher)) {
                    $voucher->increment('used');
                }
                return $order;
            }
        }
    }

    public function includes() {
        return $this->with(['address', 'voucher']);
    }

    public function scopeFilterAndSort() {
        return $this->includes()
            ->when(request('created_by'), function ($q) {
                return $q->where('created_by', request('created_by'));
            })
            ->when(request('from_date'), function ($q) {
                return $q->where('created_at', '>=', request('from_date'));
            })->when(request('to_date'), function ($q) {
                return $q->where('created_at', '<', date('Y-m-d', strtotime(request('to_date') . ' + 1 day')));
            })
            ->when(request('order_field'), function ($q) {
                return $q->orderBy((request('order_field')), (request('order_type')) ?: 'desc');
            })
            ->orderBy('id', 'desc');
    }

    public function getStatueses() {
        return [
            'Pending' => trans('app.Pending'),
            'Confirmed' => trans('app.Confirmed'),
            'Cancelled' => trans('app.Cancelled'),
            'In-Progress' => trans('app.In-Progress'),
            'In-Shipment' => trans('app.In-Shipment'),
            'Delivered' => trans('app.Delivered'),
            'Returned' => trans('app.Returned'),
        ];
    }

    public function export($rows, $fileName) {
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))
            ->download($fileName . "_" . date("Y-m-d H:i:s") . '.xlsx', function ($row) {
                return [
                    'ID' => $row->id,
                    'Contact name' => $row->contact_name,
                    'Contact mobile' => $row->contact_mobile,
                    'Sub total' => $row->sub_total . ' ' . $row->currency->title,
                    'Voucher amount' => $row->voucher_amount . ' ' . $row->currency->title,
                    'Total' => $row->total . ' ' . $row->currency->title,
                    'Address' => $row->full_address,
                    'Created at' => @$row->created_at,
                ];
            });
    }

    public function getProductsListAttribute() {
        return json_decode($this->products);
    }

}
