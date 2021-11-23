<?php

namespace App\Http\Controllers\Admin;

use Hash;

class ProfileController extends \App\Http\Controllers\Controller {

    public function __construct(\App\Models\User $model) {
        $this->module = 'profile';
        $this->title = trans('app.Profile');
        $this->model = $model;
        $this->editProfileRules = $model->editProfileRules;
        $this->changePasswordRules = $model->changePasswordRules;
    }

    public function getEdit() {
        $data['row'] = $this->model->findOrFail(auth()->user()->id);
        $data['page_title'] = $this->title . ':' . trans('app.Edit');
        return view('admin.'.$this->module . '.edit', $data);
    }

    public function postEdit() {
        $row = $this->model->findOrFail(auth()->user()->id);
        $this->validate(request(), $this->editProfileRules);
        ////////////////////////////// refresh the token
        $hash = md5(time()) . md5($row->email) . md5(RandomString(10));
        request()->request->add([
            'token'=>$hash,
        ]);
        if ($row->update(request()->except(['password']))) {
            flash()->success(trans('app.Updated successfully'));
            return back();
        }
    }

    public function getChangePassword() {
        $data['row'] = $this->model->findOrFail(auth()->user()->id);
        $data['page_title'] = $this->title . ':' . trans('app.Change password');
        return view('admin.'.$this->module . '.change-password', $data);
    }

    public function postChangePassword() {
        $this->validate(request(), $this->changePasswordRules);
        $row = $this->model->findOrFail(auth()->user()->id);
        if (!Hash::check(trim(request('old_password')), $row->password)) {
            return back()->withErrors(['old_password' => trans('app.Invalid old password')]);
        }
        ////////////////////////////// refresh the token
        $hash = md5(time()) . md5($row->email) . md5(RandomString(10));
        request()->request->add([
            'token'=>$hash,
        ]);
        if ($row->update(request()->only(['password','token']))) {
            flash(trans('app.Updated successfully'))->success();
            return back();
        }
        flash(trans('app.Failed to change password'))->error();
        return back();
    }

    public function getLogout() {
        auth()->logout();
        flash(trans('app.Log out successfully'))->success();
        return redirect('/');
    }

}
