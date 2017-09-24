<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenusRepository;
use Illuminate\Http\Request;

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

    /**
     * current template vars
     * @var
     */
    protected $template;
    protected $vars = [];
    protected $contentRightBar = FALSE;
    protected $contentLeftBar = FALSE;
    protected $bar = FALSE;

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

        $navigation = view(env('THEME').'.navigation')->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        return view($this->template)->with($this->vars);
    }

    protected function getMenu() {

        $menu = $this->m_rep->get();

        return $menu;
    }

}
