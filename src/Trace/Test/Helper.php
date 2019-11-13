<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2019/11/13
 * Time: 下午1:27
 */

namespace Ddup\Event\Trace\Test;


use Ddup\Event\Trace\Trace;

class Helper
{

    public static function change(Trace $trace)
    {
        $trace->push([
            'event' => 'new_updateUser'
        ], __FILE__, __LINE__);
    }
}