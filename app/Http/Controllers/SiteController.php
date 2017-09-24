<?php

namespace Corp\Http\Controllers;

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
    public function __construct()
    {
    }

    /**
     * @return $this
     */
    protected function renderOutput() {

        return view($this->template)->with($this->vars);
    }

}
