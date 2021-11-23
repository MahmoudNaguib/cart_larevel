<?php

namespace App\Http\Controllers\Admin;

class OrdersController extends \App\Http\Controllers\Controller {

    public function __construct(\App\Models\Order $model) {
        $this->module = 'orders';
        $this->title = trans('app.Orders');
        $this->model = $model;
    }

    public function getIndex() {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.List') . " " . $this->title;
        $data['rows'] = $this->model->filterAndSort()->paginate(env('PAGE_LIMIT', 10));
        $data['row'] = $this->model;
        return view('admin.' . $this->module . '.index', $data);
    }

    public function postChangeStatus($id) {
        authorize('change-status-' . $this->module);
        if (!in_array(request('status'), array_keys($this->model->getStatueses()))) {
            flash()->error(trans('app.You have choosed invalid status'));
            return back()->withInput();
        }
        $row = $this->model->findOrFail($id);
        if ($row->update(request()->only(['status']))) {
            flash(trans('app.Updated successfully'))->success();
            return back();
        }
        flash()->error(trans('app.failed to save'));
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
