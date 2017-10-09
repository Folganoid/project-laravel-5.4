<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;
use Menu;

class IndexController extends AdminController
{
    //
    public function __construct() {
        $this->template = env('THEME').'.admin.index';
    }

    public function index() {
        $this->start('VIEW_ADMIN');

        $this->title = 'Панель администратора';
        return $this->renderOutPut();
    }

}
