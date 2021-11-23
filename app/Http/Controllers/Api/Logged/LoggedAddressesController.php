<?php

namespace App\Http\Controllers\Api\Logged;

use App\Http\Controllers\Controller;
use Validator;

class LoggedAddressesController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Address $model) {
        $this->model = $model;
        $this->rules = $model->rules;
    }

    public function index() {
        $rows = $this->model->filterAndSort()->own()->get();
        return \App\Http\Resources\AddressResource::collection($rows);
    }

    public function pairs() {
        $rows = $this->model->own()->pluck('title', 'id');
        return response()->json($rows, 200);
    }

    public function show($id) {
        return new \App\Http\Resources\AddressResource($this->model->includes()->own()->findOrFail($id));
    }

    public function store() {
        $validator = Validator::make(request()->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json(transformValidation($validator->errors()->messages()), 422);
        }
        if ($row = $this->model->create(request()->all())) {
            return response()->json([
                'message' => trans('app.Created successfully'),
                'data' =>new \App\Http\Resources\AddressResource($row)
            ], 201);

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
                'data' =>new \App\Http\Resources\AddressResource($row)
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
