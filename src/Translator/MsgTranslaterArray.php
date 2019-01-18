<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午11:42
 */

namespace Ddup\Event\Translator;


use Ddup\Part\Message\MessageContract;

class MsgTranslaterArray extends MessageContract
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function get($attr, $def = null)
    {
        return array_get($this->container, $attr, $def);
    }

    public function set($attr, $value)
    {
        array_set($this->container, $attr, $value);
    }

    public function toArray()
    {
        return $this->container;
    }

}