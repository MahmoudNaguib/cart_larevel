<?php

namespace App\Http\Controllers\Admin;

class ReviewsController extends \App\Http\Controllers\Controller {

    public function __construct(\App\Models\Review $model) {
        $this->module = 'reviews';
        $this->title = trans('app.Reviews');
        $this->model = $model;
        $this->rules = $model->rules;
    }

    public function getIndex() {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.List') . " " . $this->title;
        $data['row'] = $this->model;
        $data['rows'] = $this->model->filterAndSort()->paginate(env('PAGE_LIMIT', 10));
        return view('admin.' . $this->module . '.index', $data);
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
