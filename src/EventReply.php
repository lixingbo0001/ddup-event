<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午9:11
 */

namespace Ddup\Event;


use Ddup\Event\Contracts\EventInterface;
use Ddup\Part\Libs\Arr;
use Ddup\Part\Message\MessageContract;
use Ddup\Event\Config\Config;
use Ddup\Event\Hook\Hook;

class EventReply
{

    private $message;
    private $event;

    public function __construct(EventInterface $event, MessageContract $message)
    {
        $this->event   = $event;
        $this->message = $message;
    }

    private function getReplys()
    {
        return [];
    }

    public function response()
    {
        $replys      = $this->getReplys();
        $hooks       = Arr::pullAll($replys, 'hook', 'type');
        $hook_handle = new Hook();
        $hook_config = new Config([], $this->event);

        $hook_config->register($hooks);

        $hook_handle->handle($hook_config, $this->message);

        return true;
    }

}