<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Validator;

class AdminCountriesController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Country $model) {
        $this->model = $model;
        $this->module = 'countries';
        $this->rules = $model->rules;
    }

    public function index() {
        authorize('view-' . $this->module);
        $rows = $this->model->filterAndSort()->get();
        return \App\Http\Resources\CountryResource::collection($rows);
    }

    public function store() {
        authorize('create-' . $this->module);
        $validator = Validator::make(request()->all(), $this->rules);
        if ($validator->fails()) {
            $res['message'] = trans('api.Invalid input data');
            $res['errors'] = transformValidation($validator->errors()->messages());
            return response()->json($res, 422);
        }
        if ($row = $this->model->create(request()->all())) {
            return response()->json([
                'message' => trans('app.Created successfully'),
                'data' => new \App\Http\Resources\CountryResource($this->model->find($row->id))
            ], 201);
        }
    }

    public function update($id) {
        authorize('edit-' . $this->module);
        $row = $this->model->findOrFail($id);
        $validator = Validator::make(request()->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json(transformValidation($validator->errors()->messages()), 422);
        }
        if ($row->update(request()->all())) {
            return response()->json([
                'message' => trans('app.Updated successfully'),
                'data' => new \App\Http\Resources\CountryResource($row)
            ], 200);
        }
        return response()->json(['message' => trans('app.Failed to save')], 400);
    }

    public function show($id) {
        authorize('view-' . $this->module);
        return new \App\Http\Resources\CountryResource($this->model->findOrFail($id));
    }

    public function destroy($id) {
        authorize('delete-' . $this->module);
        $row = $this->model->findOrFail($id);
        if ($row->delete()) {
            return response()->json([
                'message' => trans('app.Deleted successfully'),
            ], 200);
            return response()->json(['message' => trans('app.Failed to delete')], 400);
        }
    }
}
