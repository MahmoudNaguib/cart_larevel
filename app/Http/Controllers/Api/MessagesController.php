<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator;

class MessagesController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Message $model) {
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
        if ($row = $this->model->create(request()->all())) {
            return response()->json([
                'message' => trans('app.Created successfully'),
                'data' =>new \App\Http\Resources\MessageResource($row)
            ], 201);
        }
        return response()->json(['message' => trans('app.Failed to save')], 400);
    }

}
