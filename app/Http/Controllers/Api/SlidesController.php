<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator;

class SlidesController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Slide $model) {
        $this->model = $model;
    }

    public function index() {
        $rows = $this->model->filterAndSort()->get();
        return \App\Http\Resources\SlideResource::collection($rows);
    }

    public function show($id) {
        return new \App\Http\Resources\SlideResource($this->model->findOrFail($id));
    }

}
