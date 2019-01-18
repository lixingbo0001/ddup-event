<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午11:37
 */

namespace Ddup\Event;


use Ddup\Event\Translator\MsgTranslaterArray;
use Ddup\Event\Translator\MsgTranslaterXml;
use Ddup\Part\Libs\Helper;
use Ddup\Part\Message\MessageContract;

class EventMessage extends MessageContract
{

    private $container;

    public function __construct($message)
    {

        switch (gettype($message)) {
            case 'string':
                $this->container = new MsgTranslaterXml($message);
                break;
            default:
                $message         = Helper::toArray($message);
                $this->container = new MsgTranslaterArray($message);
                break;
        }
    }

    public function get($attr, $def = null)
    {
        return $this->container->get($attr, $def);
    }

    public function set($attr, $value)
    {
        $this->container->set($attr, $value);
    }

    public function toArray()
    {
        return $this->container->toArray();
    }
}