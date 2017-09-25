<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 25.09.17
 * Time: 16:37
 */

namespace Corp\Repositories;

use Corp\Slider;

class SlidersRepository extends Repository
{
    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }

}