<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午11:37
 */

namespace Ddup\Event;


use Ddup\Part\Libs\Helper;
use Ddup\Part\Message\MessageContract;
use Ddup\Part\Message\MsgFromArray;
use Ddup\Part\Message\MsgFromXml;

class EventMessage extends MessageContract
{

    private $container;

    public function __construct($message)
    {

        switch (gettype($message)) {
            case 'string':
                $this->container = new MsgFromXml($message);
                break;
            default:
                $message         = Helper::toArray($message);
                $this->container = new MsgFromArray($message);
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