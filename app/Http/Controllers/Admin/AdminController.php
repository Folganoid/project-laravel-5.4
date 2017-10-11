<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Menu;
use Auth;
use Gate;

class AdminController extends Controller
{
    //
    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $template;
    protected $content = FALSE;
    protected $title;
    protected $vars;

    public function checkAuth() {
        $this->user = Auth::user();
        if(!$this->user) {
           abort(403);
        }
    }

    public function renderOutPut() {

        $this->vars = array_add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();

        $navigation = view(env('THEME').'.admin.navigation')->with('menu', $menu)->render();

        $this->vars = array_add($this->vars, 'navigation', $navigation);

        if($this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        $footer = view(env('THEME').'.admin.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);

    }

    public function getMenu() {

        return Menu::make('adminMenu', function($menu) {

            $menu->add('Статьи', ['route' => 'article.index']);
            $menu->add('Портфолио', ['route' => 'article.index']);
            $menu->add('Меню', ['route' => 'article.index']);
            $menu->add('Пользователи', ['route' => 'article.index']);
            $menu->add('Привилегии', ['route' => 'article.index']);
        });
    }

    public function start($role) {
        $this->checkAuth();
        if(Gate::denies($role)) {
            abort(403);
        }
    }

}
