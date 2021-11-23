<?php

namespace App\Http\Controllers\Api\Logged;

use App\Http\Controllers\Controller;
use Validator;

class LoggedOrdersController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Order $model) {
        $this->model = $model;
        $this->rules = $model->rules;
    }

    public function index() {
        $rows = $this->model->filterAndSort()->own()->paginate(env('PAGE_LIMIT', 10));
        return \App\Http\Resources\OrderResource::collection($rows);
    }

    public function show($id) {
        $row = $this->model->own()->findOrFail($id);
        if ($row)
            return new \App\Http\Resources\OrderResource($row);
    }

    public function store() {
        ////////////////////// Check if product exists in cart
        $cartCount = \App\Models\Cart::with(['product'])->where('created_by', auth()->user()->id)->count();
        if (!$cartCount) {
            return response()->json(['message' => trans('app.There is not products in the cart to create order')], 400);
        }
        ////////////////////// Check if address exists
        if (request('address_id'))
            $addrss = \App\Models\Address::own()->find(request('address_id'));
        if (!$addrss) {
            return response()->json(['message' => trans('app.There is no address in your profile')], 400);
        }
        $cart=\App\Models\Cart::with(['product'])->own()->get();
        if(!$cart){
            return response()->json(['message' => trans('app.There is no products in your cart')], 400);
        }
        ///////////////// Create Order
        if ($row = $this->model->createOrder(auth()->user(), ['address_id' => $addrss->id])) {
            return response()->json([
                'message' => trans('app.Created successfully'),
                'data' =>new \App\Http\Resources\OrderResource($row)
            ], 201);
        }
        return response()->json(['message' => trans('app.Failed to save')], 400);
    }

}
