<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator;

class SectionsController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Section $model) {
        $this->model = $model;
    }

    public function index() {
        $rows = $this->model->filterAndSort()->whereNull('top_id')->get();
        return \App\Http\Resources\SectionResource::collection($rows);
    }

    public function pairs() {
        $rows = $this->model->getSectionsWithParents();
        return response()->json($rows, 200);
    }

    public function show($id) {
        return new \App\Http\Resources\SectionResource($this->model->findOrFail($id));
    }

}
