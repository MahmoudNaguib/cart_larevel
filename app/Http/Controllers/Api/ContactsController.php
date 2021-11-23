<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator;

class ContactsController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Contact $model) {
        $this->model = $model;
        $this->rules = $model->rules;
    }

    public function store() {
        //////////////////////////////////////// Validation
        $validator = Validator::make(request()->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json(transformValidation($validator->errors()->messages()), 422);
        }
        //////////////////////////////////////
        $exist=$this->model->where('email',request('email'))->first();
        if($exist){
            return response()->json([
                'message' => trans('app.You have already subscribed to our newsletter'),
                'data' =>new \App\Http\Resources\ContactResource($exist)
            ], 201);
        }
        if ($row = $this->model->create(request()->all())) {
            return response()->json([
                'message' => trans('app.Subscribed successfully'),
                'data' =>new \App\Http\Resources\ContactResource($row)
            ], 201);
        }
        return response()->json(['message' => trans('app.Failed to save')], 400);
    }

}
