<?php

namespace App\Http\Controllers\Admin;

class UsersController extends \App\Http\Controllers\Controller {

    public function __construct(\App\Models\User $model) {
        $this->module = 'users';
        $this->title = trans('app.Users');
        $this->model = $model;
        $this->adminCreateRules = $model->adminCreateRules;
        $this->adminEditRules = $model->adminEditRules;
    }

    public function getIndex() {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.List') . " " . $this->title;
        $data['rows'] = $this->model->filterAndSort()->paginate(env('PAGE_LIMIT', 10));
        return view('admin.' . $this->module . '.index', $data);
    }

    public function getCreate() {
        authorize('create-' . $this->module);
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.Create') . " " . $this->title;
        $data['breadcrumb'] = [$this->title => 'admin/' . $this->module];
        $data['row'] = $this->model;
        return view('admin.' . $this->module . '.create', $data);
    }

    public function postCreate() {
        authorize('create-' . $this->module);
        $this->validate(request(), $this->adminCreateRules);
        if ($row = $this->model->create(request()->except(['password_confirmation']))) {
            flash()->success(trans('app.Created successfully'));
            return redirect(lang() . '/admin/' . $this->module);
        }
        flash()->error(trans('app.failed to save'));
    }

    public function getEdit($id) {
        authorize('edit-' . $this->module);
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.Edit') . " " . $this->title;
        $data['breadcrumb'] = [$this->title => 'admin/' . $this->module];
        $data['row'] = $this->model->findOrFail($id);
        return view('admin.' . $this->module . '.edit', $data);
    }

    public function postEdit($id) {
        authorize('edit-' . $this->module);
        $this->adminEditRules['email'] .= ',' . $id . ',id,deleted_at,NULL';
        $this->validate(request(), $this->adminEditRules);
        $row = $this->model->findOrFail($id);
        if ($row->update(request()->except(['password_confirmation']))) {
            flash(trans('app.Updated successfully'))->success();
            return back();
        }
    }

    public function getView($id) {
        authorize('view-' . $this->module);
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.View') . " " . $this->title;
        $data['breadcrumb'] = [$this->title => 'admin/' . $this->module];
        $data['row'] = $this->model->findOrFail($id);
        return view('admin.' . $this->module . '.view', $data);
    }

    public function getDelete($id) {
        authorize('delete-' . $this->module);
        $row = $this->model->findOrFail($id);
        $row->delete();
        flash()->success(trans('app.Deleted Successfully'));
        return back();
    }

    public function getExport() {
        authorize('view-' . $this->module);
        $rows = $this->model->filterAndSort()->get();
        if ($rows->isEmpty()) {
            flash()->error(trans('app.There is no results to export'));
            return back();
        }
        return $this->model->export($rows, $this->module);
    }

}
