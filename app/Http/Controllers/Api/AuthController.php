<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    /*
     * 200: success
     * 201 created
     * 401: unauthorized
     * 404: page not found
     * 400: Bad Request
     * 422: Validation error
     * 403: Forbidden
     */

    public function __construct(\App\Models\User $model) {
        $this->model = $model;
        $this->registerRules = $model->registerRules;
        $this->loginRules = $model->loginRules;
        $this->forgotRules = $model->forgotRules;
    }

    public function postLogin() {
        $validator = Validator::make(request()->all(), $this->loginRules);
        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 422);
        }
        $row = $this->model->where('email', request('email'))->first();
        if (!$row) {
            $message = trans('app.There is no account with this email');
            return response()->json(['message' => $message], 403);
        }
        if (!$row->confirmed) {
            $message = trans('app.This account is not confirmed') . ', ' . trans('app.Please check your email to confirm your account');
            return response()->json(['message' => $message], 403);
        }
        if (!$row->is_active) {
            $message = trans('app.This account is banned');
            return response()->json(['message' => $message], 403);
        }
        if (!Hash::check(trim(request('password')), $row->password)) {
            $message = trans('app.Trying to login with invalid password');
            return response()->json(['message' => $message], 403);
        }
        ///////////////////////////////// update token
        $data=[
            'last_logged_in_at'=>date("Y-m-d H:i:s"),
            'last_ip'=>$_SERVER['REMOTE_ADDR'],
            'token'=>($row->token)?:generateToken(request('email'))
        ];
        if($row->update($data)){
            \Auth::login($row);
            //////// if push_token
            if(request('push_token')){
                $pushToken=\App\Models\PushToken::where('token',request('push_token'))
                    ->where('created_by',$row->id)->first();
                if(!$pushToken){
                    \App\Models\PushToken::create(['token'=>request('push_token')]);
                }
            }
            ////////
            request()->headers->set('Authorization','Bearer '. $row->token);
            return response()->json([
                'message' => trans('app.Successfully logged in'),
                'data' => new \App\Http\Resources\UserResource($this->model->includes()->findOrFail($row->id))
            ], 200);
        }
        return response()->json(['message' => trans('app.Failed to login')], 400);
    }

    public function postRegister() {
        $validator = Validator::make(request()->all(), $this->registerRules);
        if ($validator->fails()) {
            return response()->json(transformValidation($validator->errors()->messages()), 422);
        }
        $token =generateToken(request('email'));
        request()->request->add([
            'confirm_token' => md5(request('email')) . RandomString(10) . md5(time()),
            'remember_token' => md5(request('email')) . RandomString(10) . md5(time()),
            'token'=>$token,
            'country_id'=>64,
            'last_logged_in_at'=>date("Y-m-d H:i:s"),
            'last_ip'=>$_SERVER['REMOTE_ADDR']
        ]);
        if ($row = $this->model->create(request()->except(['password_confirmation']))) {
            return response()->json([
                'message' => trans('app.Registration successfully'),
                'data' => new \App\Http\Resources\UserResource($this->model->includes()->findOrFail($row->id))
            ], 201);
        }
        return response()->json(['message' => trans('app.Failed to save')], 400);
    }

    public function postForgotPassword() {
        $validator = Validator::make(request()->all(), $this->forgotRules);
        if ($validator->fails()) {
            return response()->json(transformValidation($validator->errors()->messages()), 422);
        }
        $row = $this->model->where('email', request('email'))->first();
        if (!$row) {
            $message = trans('app.There is no account with this email');
            return response()->json(['message' => $message], 403);
        }
        if (!$row->confirmed) {
            $message = trans('app.This account is not confirmed') . ', ' . trans('app.Please check your email to confirm your account');
            return response()->json(['message' => $message], 403);
        }
        if (!$row->is_active) {
            $message = trans('app.This account is banned');
            return response()->json(['message' => $message], 403);
        }
        $password = RandomString(10);
        if (app()->environment() == 'production') {
            \App\Jobs\SendForgotEmail::dispatch($row, $password);
            return response()->json(['message' => trans('app.Your new password has been sent to your email')], 200);
        } else {
            return response()->json(['message' => trans('app.Password will be changed in production mode only')], 200);
        }
        return response()->json(['message' => trans('app.Failed to send')], 400);
    }

}
