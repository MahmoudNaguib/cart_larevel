<?php

namespace App\Http\Controllers\Admin;

class TranslatorController extends \App\Http\Controllers\Controller {

    public function __construct() {
        $this->module = 'translator';
        $this->title = trans('app.Translator');
    }

    public function getIndex() {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.Translator');
        $data['rows'] = getListOfFiles(resource_path() . '/lang/en');
        return view('admin.' . $this->module . '.index', $data);
    }

    public function getEdit($file) {
        authorize('edit-' . $this->module);
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.Translator');
        $data['breadcrumb'] = [$this->title => 'admin/' . $this->module];
        if (!is_array(trans($file))) {
            return abort(404);
        }
        foreach (langs() as $lang) {
            $data['rows'][$lang] = trans($file, [], $lang);
        }
        return view('admin.' . $this->module . '.edit', $data);
    }

    public function postEdit($file) {
        foreach (langs() as $lang) {
            $text = "<?php \n return [\n";
            foreach (request($lang) as $key => $value) {
                $text .= "'{$key}' => '{$value}',\n";
            }
            $text .= "];";
            @file_put_contents(resource_path() . '/lang/' . $lang . '/' . $file . '.php', $text);
        }
        flash(trans('app.Updated successfully'))->success();
        return back();
    }

}
