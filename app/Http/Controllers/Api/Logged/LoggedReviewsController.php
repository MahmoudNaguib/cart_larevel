<?php

namespace App\Http\Controllers\Api\Logged;

use App\Http\Controllers\Controller;
use Validator;

class LoggedReviewsController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Review $model) {
        $this->model = $model;
        $this->rules = $model->rules;
    }

    public function index() {
        $rows = $this->model->filterAndSort()->own()->paginate(env('PAGE_LIMIT', 10));
        return \App\Http\Resources\ReviewResource::collection($rows);
    }

    public function show($id) {
        return new \App\Http\Resources\ReviewResource($this->model->own()->findOrFail($id));
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
                'data' =>new \App\Http\Resources\ReviewResource($row)
            ], 201);
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
