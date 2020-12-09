<?php

namespace app\admin\controller;

use app\BaseController;
use app\common\controller\Base;
use think\facade\View;

class Error extends Base {

    public function __call($method, $args)
    {
        return view('error/error');
    }
}