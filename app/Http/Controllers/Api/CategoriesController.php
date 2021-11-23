<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator;

class CategoriesController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Category $model) {
        $this->model = $model;
    }

    public function index() {
        $rows = $this->model->filterAndSort()->whereNull('top_id')->get();
        return \App\Http\Resources\CategoryResource::collection($rows);
    }

    public function pairs() {
        $rows = $this->model->pluck('title', 'id');
        return response()->json($rows, 200);
    }

    public function show($id) {
        return new \App\Http\Resources\CategoryResource($this->model->findOrFail($id));
    }

}
