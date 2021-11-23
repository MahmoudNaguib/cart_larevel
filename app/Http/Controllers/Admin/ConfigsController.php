<?php

namespace App\Http\Controllers\Admin;

use Intervention\Image\Facades\Image;
use File;

class ConfigsController extends \App\Http\Controllers\Controller {

    public function __construct(\App\Models\Config $model) {
        $this->module = 'configs';
        $this->title = trans('app.Configs');
        $this->model = $model;
    }

    public function getEdit() {
        authorize('edit-' . $this->module);
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.Create') . " " . $this->title;
        $data['breadcrumb'] = [$this->title => $this->module . '/edit'];
        $data['rows'] = $this->model->get()->groupBy('type');
        //dd($data['rows']);
        return view('admin.' . $this->module . '.edit', $data);
    }

    public function postEdit() {
        authorize('edit-' . $this->module);
        $rows = $this->model->get();
        if ($rows) {
            foreach ($rows as $row) {
                if ($row->field_type == 'file') {
                    $field = 'input_' . $row->id;
                    if (request()->hasFile($field)) {
                        $uploadPath = 'uploads';
                        $image = request()->file($field);
                        $fileName = strtolower(str_random(10)) . time() . '.' . $image->getClientOriginalExtension();
                        request()->file($field)->move($uploadPath, $fileName);
                        $filePath = $uploadPath . '/' . $fileName;
                        if ($filePath) {
                            $imageSizes = ['small' => 'resize,200x200', 'large' => 'resize,400x300'];
                            foreach ($imageSizes as $key => $value) {
                                $value = explode(',', $value);
                                $type = $value[0];
                                $dimensions = explode('x', $value[1]);
                                if (!File::exists($uploadPath . '/' . $key)) {
                                    @mkdir($uploadPath . '/' . $key);
                                    @chmod($uploadPath . '/' . $key, 0777);
                                }
                                $thumbPath = $uploadPath . '/' . $key . '/' . $fileName;
                                $image = Image::make($filePath);
                                if ($type == 'crop') {
                                    $image->fit($dimensions[0], $dimensions[1]);
                                } else {
                                    $image->resize($dimensions[0], $dimensions[1], function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                }
                                $image->save($thumbPath);
                            }
                            @unlink($filePath);
                        }
                        $row->value = $fileName;
                        $row->save();
                    }
                } else {
                    $row->value = request('input_' . $row->id);
                    $row->save();
                }
            }
        }
        \Cache::forget('configs');
        flash(trans('app.Updated successfully'))->success();
        return back();
    }

}
