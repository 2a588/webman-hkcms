<?php

namespace app\controller;

use support\Request;

class TextController
{
    public function index(Request $request)
    {
        return response('hello Text');
    }

    public function view(Request $request)
    {
        return view('index/view', ['name' => 'text']);
    }

    public function json(Request $request)
    {
        return json(['code' => 0, 'msg' => 'ok']);
    }

}
