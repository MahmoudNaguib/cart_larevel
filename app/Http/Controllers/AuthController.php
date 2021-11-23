<?php

namespace App\Http\Controllers;

use Auth;
use Hash;

class AuthController extends Controller {

    public function __construct(\App\Models\User $model) {
        $this->middleware('guest', ['except' => ['getConfirm']]);
        $this->module = 'auth';
        $this->model = $model;
        $this->registerRules = $model->registerRules;
        $this->loginRules = $model->loginRules;
        $this->forgotRules = $model->forgotRules;
    }

    public function postLogin() {
        $this->validate(request(), $this->loginRules);
        $row = $this->model->where('email', trim(request('email')))
            ->whereNotNull('role_id')
            ->first();
        if (!$row) {
            $message = trans('app.There is no account with this email');
            flash()->error($message);
            return back()->withInput();
        }
        if (!$row->confirmed) {
            $message = trans('app.This account is not confirmed') . ', ' . trans('app.Please check your email to confirm your account');
            flash()->error($message);
            return back()->withInput();
        }
        if (!$row->is_active) {
            $message = trans('app.This account is banned');
            flash()->error($message);
            return back()->withInput();
        }
        if (!Hash::check(trim(request('password')), $row->password)) {
            $message = trans('app.Trying to login with invalid password');
            flash()->error($message);
            return back()->withInput();
        }
        if (Auth::attempt(request()->only('email', 'password'))) {
            if (request()->has('to')) {
                return redirect(request('to'));
            }
            $row->last_ip = request()->ip();
            $row->last_logged_in_at = date('Y-m-d H:i:s');
            $row->save();
            flash()->success(trans('app.Welcome to your dashboard'));
            if ($row->role_id)
                return redirect('/' . $row->language . '/admin/dashboard');
            else
                return redirect('/' . $row->language);
        }
        flash()->error(trans('app.Failed to login'));
        return back();
    }

    public function postRegister() {
        if (env('ENABLE_CAPTCHA') == 1) {
            $this->rules['g-recaptcha-response'] = 'required';
        }
        $this->validate(request(), $this->registerRules);
        $hash = md5(time()) . md5(request('email')) . md5(RandomString(10));
        request()->request->add([
            'confirm_token' => md5(request('email')) . RandomString(10) . md5(time()),
            'remember_token' => md5(request('email')) . RandomString(10) . md5(time()),
            'token' => $hash,
            'country_id' => 64,
            'last_logged_in_at' => date("Y-m-d H:i:s"),
            'last_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        if ($row = $this->model->create(request()->except(['password_confirmation', 'g-recaptcha-response']))) {
            flash()->success(trans('app.Account has been created successfully, Please check your email'));
            return back();
        }
        flash()->error(trans('app.Failed to login'));
        return back();
    }

    public function postForgotPassword() {
        $this->validate(request(), $this->forgotRules);
        $row = $this->model->where('email', trim(request('email')))
            ->whereNotNull('role_id')
            ->first();
        if (!$row) {
            flash()->error(trans('app.There is no account with this email'));
            return back()->withInput();
        }
        if (!$row->confirmed) {
            flash()->error(trans('app.This account is not confirmed'));
            return back()->withInput();
        }
        if (!$row->is_active) {
            flash()->error(trans('app.This account is banned'));
            return back()->withInput();
        }
        if (app()->environment() == 'production') {
            $password = RandomString(8);
            \App\Jobs\SendForgotEmail::dispatch($row, $password);
            flash()->success(trans('app.Your new password has been sent to your email'));
            return back();
        } else {
            flash()->success(trans('app.Password will be changed in production mode only'));
            return back();
        }
    }

    public function getRegister() {
        $data['page_title'] = trans('app.User registeration');
        $data['module'] = $this->module;
        $data['row'] = $this->model;
        return view($this->module . '.register', $data);
    }

    public function getLogin() {
        $data['page_title'] = trans('app.Login');
        $data['module'] = $this->module;
        $data['row'] = $this->model;
        return view($this->module . '.login', $data);
    }

    public function getForgotPassword() {
        $data['page_title'] = trans('app.Forgot password');
        $data['module'] = $this->module;
        $data['row'] = $this->model;
        return view($this->module . '.forgot', $data);
    }

    public function getConfirm($token) {
        $data['page_title'] = trans('app.Confirm account');
        $data['module'] = $this->module;
        $data['row'] = $this->model->where('confirm_token', $token)->first();
        if ($data['row']) {
            $data['message'] = trans('app.Your account has been confirmed');
            $data['row']->confirm_token = Null;
            $data['row']->confirmed = 1;
            $data['row']->save();
        } else {
            $data['message'] = trans('app.Invalid activation token');
        }
        return view($this->module . '.confirm', $data);
    }

}
