<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午9:11
 */

namespace Ddup\Event;


use Ddup\Event\Config\ConfigStruct;
use Ddup\Event\Contracts\EventInterface;
use Ddup\Part\Libs\Arr;
use Ddup\Part\Message\MessageContract;
use Ddup\Event\Config\EventConfig;
use Ddup\Event\Hook\Hook;

class EventReply
{

    private $message;
    private $event;
    private $config;

    public function __construct(EventInterface $event, MessageContract $message, ConfigStruct $config)
    {
        $this->event   = $event;
        $this->message = $message;
        $this->config  = $config;
    }

    private function getReplys()
    {
        return [];
    }

    private function defaultHooks()
    {
        return array_get($this->config->events, $this->event->eventName(), []);
    }

    private function dymicHooks()
    {
        $replys = $this->getReplys();
        return Arr::pullAll($replys, 'hook', 'type');
    }

    public function response()
    {
        $hook_handle = new Hook($this->config->hook_path);
        $hook_config = new EventConfig($this->defaultHooks());

        $hook_config->register($this->dymicHooks());

        $hook_handle->handle($hook_config, $this->message);

        return true;
    }

}