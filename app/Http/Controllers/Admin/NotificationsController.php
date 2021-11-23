<?php

namespace App\Http\Controllers\Admin;

class NotificationsController extends \App\Http\Controllers\Controller {

    public $model;
    public $module;

    public function __construct(\App\Models\Notification $model) {
        $this->module = 'notifications';
        $this->title = trans('app.Notifications');
        $this->model = $model;
    }

    public function getIndex() {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.List') . " " . $this->title;
        $data['rows'] = $this->model->filterAndSort()->own()->paginate(env('PAGE_LIMIT', 10));
        return view('admin.' .$this->module . '.index', $data);
    }

    public function getTo($id) {
        $row = $this->model->findOrFail($id);
        $row->seen_at = date("Y-m-d H:i:s");
        $row->save();
        if ($row->url) {
            return redirect($row->url);
        }
        return back();
    }
    public function getView($id) {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.View') . " " . $this->title;
        $data['breadcrumb'] = [$this->title => $this->module];
        $data['row'] = $this->model->where('id', $id)->first();
        $data['row']->seen_at = date("Y-m-d H:i:s");
        $data['row']->save();
        if (!$data['row'])
            return abort(404);
        return view('admin.' .$this->module . '.view', $data);
    }

    public function getDelete($id) {
        $row = $this->model->where('user_id', auth()->user()->id)->where('id', $id)->first();
        if (!$row)
            return abort(404);
        $row->delete();
        flash()->success(trans('app.Deleted Successfully'));
        return back();
    }

    public function getExport() {
        $rows = $this->model->filterAndSort()->get();
        if ($rows->isEmpty()) {
            flash()->error(trans('app.There is no results to export'));
            return back();
        }
        return $this->model->export($rows, $this->module);
    }

}
