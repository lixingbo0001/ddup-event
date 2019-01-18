<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/9
 * Time: 下午4:00
 */

namespace Ddup\Event\Config;

use Ddup\Part\Struct\StructReadable;

class ConfigStruct extends StructReadable
{
    public $name     = 'not';
    public $is_async = 0;
    public $delay    = 0;
    public $condition_op;
    public $condition_key;
    public $condition_val;

}