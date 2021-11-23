<?php

namespace App\Http\Controllers\Api\Logged;

use App\Http\Controllers\Controller;
use Validator;

class LoggedCartController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Cart $model) {
        $this->model = $model;
        $this->rules = $model->rules;
    }

    public function index() {
        $rows = $this->model->filterAndSort()->own()->paginate(env('PAGE_LIMIT', 10));
        return \App\Http\Resources\CartResource::collection($rows);
    }

    public function show($id) {
        return new \App\Http\Resources\CartResource($this->model->own()->findOrFail($id));
    }

    public function store() {
        //////////////////////////////////////// Validation
        $validator = Validator::make(request()->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json(transformValidation($validator->errors()->messages()), 422);
        }
        ////////////////////// Check if product exists in cart, if exists increment quantity
        $row = $this->model->where('product_id', request('product_id'))->own()->first();
        if ($row) {
            $row->increment('quantity');
            return response()->json([
                'message' => trans('app.Created successfully'),
                'data' =>new \App\Http\Resources\CartResource($row)
            ], 201);
        } else {
            if ($row = $this->model->create(request()->all())) {
                return response()->json([
                    'message' => trans('app.Created successfully'),
                    'data' =>new \App\Http\Resources\CartResource($row)
                ], 201);
            }
        }
        return response()->json(['message' => trans('app.Failed to save')], 400);
    }

    public function update($id) {
        $row = $this->model->own()->findOrFail($id);
        $validator = Validator::make(request()->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json(transformValidation($validator->errors()->messages()), 422);
        }
        if ($row->update(request()->all())) {
            return response()->json([
                'message' => trans('app.Updated successfully'),
                'data' =>new \App\Http\Resources\CartResource($row)
            ], 200);
        }
        return response()->json(['message' => trans('app.Failed to save')], 400);
    }

    public function destroy($id) {
        $row = $this->model->own()->findOrFail($id);
        if($row->delete()){
            return response()->json([
                'message' => trans('app.Deleted successfully'),
            ], 200);
            return response()->json(['message' => trans('app.Failed to delete')], 400);
        }
    }

}
