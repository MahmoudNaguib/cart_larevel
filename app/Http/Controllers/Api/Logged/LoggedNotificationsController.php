<?php

namespace App\Http\Controllers\Api\Logged;

use App\Http\Controllers\Controller;
use Validator;

class LoggedNotificationsController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\Notification $model) {
        $this->model = $model;
    }

    public function index() {
        $rows = $this->model->filterAndSort()->own()->paginate(env('PAGE_LIMIT', 10));
        return \App\Http\Resources\NotificationResource::collection($rows);
    }

    public function show($id) {
        $row = $this->model->own()->findOrFail($id);
        $row->seen_at = date('Y-m-d H:i:s');
        $row->save();
        if ($row)
            return new \App\Http\Resources\NotificationResource($row);
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
