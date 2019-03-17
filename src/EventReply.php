<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午9:11
 */

namespace Ddup\Event;


use Ddup\Event\Config\ConfigStruct;
use Ddup\Event\Config\HookStruct;
use Ddup\Event\Contracts\EventInterface;
use Ddup\Event\Contracts\MatcherCallable;
use Ddup\Part\Libs\Arr;
use Ddup\Part\Message\MessageContract;
use Ddup\Event\Hook\Hook;

class EventReply implements MatcherCallable
{

    private $message;
    private $event;
    private $config;
    private $materials;
    private $_replys;

    public function __construct(EventInterface $event, MessageContract $message, ConfigStruct $config)
    {
        $this->event   = $event;
        $this->message = $message;
        $this->config  = $config;

        $this->setReplys([]);
    }

    public function setReplys($replys)
    {
        $this->_replys = $replys;
    }

    public function callback(HookStruct $struct, MessageContract $message)
    {
        $this->materials[] = $struct->toArray();
    }

    private function filterMaterial($replys)
    {
        $matcher = new Matcher();

        $matcher->call($replys, $this->message, $this);
    }

    private function defaultHooks()
    {
        return array_get($this->config->events, $this->event->eventName(), []);
    }

    private function hookhandle($dymic_hooks)
    {
        $hook_handle = new Hook($this->config->hook_path);

        $hooks = array_merge($this->defaultHooks(), $dymic_hooks);

        $hook_handle->handle($hooks, $this->message);
    }

    public function response()
    {
        $replys = $this->_replys;

        $dymic_hooks = Arr::pullAll($replys, 'hook', 'type');

        $this->hookhandle($dymic_hooks);

        $this->filterMaterial($replys);

        return $this->materials;
    }

}