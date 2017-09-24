<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 24.09.17
 * Time: 19:01
 */

namespace Corp\Repositories;

use Config;

abstract class Repository
{

    protected $model = FALSE;

    public function get() {

        $builder = $this->model->select('*');

       return $builder->get();
    }

}