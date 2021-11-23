<?php

namespace App\Http\Controllers\Api\Logged;

use App\Http\Controllers\Controller;
use Hash;
use Validator;

class LoggedProfileController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public $model;

    public function __construct(\App\Models\User $model) {
        $this->model = $model;
        $this->editProfileRules = $model->editProfileRules;
        $this->changePasswordRules = $model->changePasswordRules;
        $this->changeImageRules = $model->changeImageRules;
    }

    public function getIndex() {
        return new \App\Http\Resources\UserResource($this->model->includes()->findOrFail(auth()->user()->id));
    }

    public function postEdit() {
        $row = \App\Models\User::findOrFail(auth()->user()->id);
        $this->editProfileRules['email'] .= ',' . $row->id . ',id,deleted_at,NULL';
        $validator = Validator::make(request()->all(), $this->editProfileRules);
        if ($validator->fails()) {
            return response()->json(transformValidation($validator->errors()->messages()), 422);
        }
        $oldEmail=$row->email;
        $oldName=$row->name;
        if ($row->update(request()->except(['password']))) {
            ////////////////////// Update token if email or name changed
            if($oldName!=request('name') || $oldEmail!=request('email')){
                $row->token=generateToken(request('email'));
                $row->save();
                request()->headers->set('Authorization','Bearer '. $row->token);
            }
            //////////////////////
            return response()->json([
                'message' => trans('app.Edit successfully'),
                'data' => new \App\Http\Resources\UserResource($this->model->includes()->findOrFail($row->id))
            ], 200);
        }
        return response()->json(['message' => trans('app.Failed to save')], 400);
    }

    public function postChangePassword() {
        $row = $this->model->findOrFail(auth()->user()->id);
        $validator = Validator::make(request()->all(), $this->changePasswordRules);
        if ($validator->fails()) {
            return response()->json(transformValidation($validator->errors()->messages()), 422);
        }
        ////////////////////// Update token if email or name changed
        if (!Hash::check(trim(request('password')), $row->password)) {
            request()->request->add([
                'token'=>generateToken(request('email')),
            ]);
        }
        //////////////////////
        if ($row->update(request()->only(['password','token']))) {
            request()->headers->set('Authorization','Bearer '. $row->token);
            return response()->json([
                'message' => trans('app.Password changed successfully'),
                'data' => new \App\Http\Resources\UserResource($this->model->includes()->findOrFail($row->id))
            ], 200);
        }
        return response()->json(['message' => trans('app.Failed to save')], 400);
    }

    public function postChangeImage() {
        $row = auth()->user();
        $validator = Validator::make(request()->all(), $this->changeImageRules);
        if ($validator->fails()) {
            return response()->json(transformValidation($validator->errors()->messages()), 422);
        }
        if ($row->update(request()->only(['image']))) {
            return new \App\Http\Resources\UserResource($this->model->includes()->findOrFail($row->id));
        }
        return response()->json(['message' => trans('app.Failed to change image')], 400);
    }

    public function getLogout() {
        $this->model->where('id',auth()->user()->id)->update(['token'=>NULL]);
        auth()->logout();
        return response()->json(['message' => trans('app.Log out successfully')], 200);
    }

}
