<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Menu;

class SiteController extends Controller
{
    /**
     * portfolios repository
     * @var
     */
    protected $p_rep;

    /**
     * slider repository
     * @var
     */
    protected $s_rep;
    /**
     * articles repository
     * @var
     */
    protected $a_rep;

    /**
     * menus repository
     * @var
     */
    protected $m_rep;

    protected $keywords;
    protected $meta_desc;
    protected $title;

    /**
     * current template vars
     * @var
     */
    protected $template;
    protected $vars = [];
    protected $contentRightBar = FALSE;
    protected $contentLeftBar = FALSE;
    protected $bar = 'no';

    /**
     * SiteController constructor.
     */
    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    /**
     * @return $this
     */
    protected function renderOutput() {

        $menu = $this->getMenu();

        $navigation = view(env('THEME').'.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        if($this->contentRightBar) {
            $rightBar = view(env('THEME').'.rightBar')->with('content_rightBar', $this->contentRightBar)->render();
            $this->vars = array_add($this->vars, 'rightBar', $rightBar);
        }

        $this->vars = array_add($this->vars, 'bar', $this->bar);

        $this->vars = array_add($this->vars, 'keywords', $this->keywords);
        $this->vars = array_add($this->vars, 'meta_desc', $this->meta_desc);
        $this->vars = array_add($this->vars, 'title', $this->title);


        $footer = view(env('THEME').'.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }

    /**
     * get menu
     * @return mixed
     */
    protected function getMenu() {

        $menu = $this->m_rep->get();

        $mBuilder = Menu::make('MyNav', function($m) use ($menu) {
            foreach($menu as $item)
                if($item->parent == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                }
                else {
                    if($m->find($item->parent)) {
                        $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                    }
                }
        });

        //dd($mBuilder);

        return $mBuilder;
    }

}
