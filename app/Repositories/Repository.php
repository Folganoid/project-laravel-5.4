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

    public function get($select = '*', $take = FALSE) {

        $builder = $this->model->select($select);

        if($take) {
            $builder->take($take);
        }

       return $builder->get();
    }

}