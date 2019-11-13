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
use Ddup\Event\Hook\HookDispatcher;
use Ddup\Event\Trace\Trace;
use Ddup\Event\Trace\TraceCollection;
use Ddup\Part\Libs\Arr;
use \Illuminate\Support\Arr as Arrs;
use Ddup\Part\Message\MessageContract;
use Ddup\Event\Hook\HookFactory;

class EventReply
{

    private $_config;
    private $_message;
    private $_hooks;
    private $_event;
    private $_replys;
    private $_materials = [];

    /**
     * @var Trace
     */
    private $_trace_hook;
    /**
     * @var TraceCollection
     */
    private $_trace_collection;

    public function __construct(EventInterface $event, MessageContract $message, ConfigStruct $config)
    {
        $this->_event   = $event;
        $this->_message = $message;
        $this->_config  = $config;

        $this->setTrace();

        $this->setReplys([]);
    }

    private function setTrace()
    {
        $this->_trace_hook       = new Trace('hook');
        $this->_trace_collection = new TraceCollection();

        $this->_trace_collection->push($this->_trace_hook);
    }

    public function setReplys($replys)
    {
        $this->_replys = $replys;
    }

    private function filterMaterial()
    {
        $matcher = new Matcher();

        $matcher->call($this->_replys, $this->_message, function (HookStruct $struct, MessageContract $message) {
            unset($message);

            $this->_materials[] = $struct->toArray();
        });
    }

    private function defaultHooks()
    {
        $this->_trace_hook->push($this->_config->events, [__FILE__, __LINE__], "记录config的原始hooks");

        $hooks = Arrs::get($this->_config->events, $this->_event->eventName(), []);

        $this->_trace_hook->push($hooks, [__FILE__, __LINE__], "记录config中匹配到的hooks");

        return $hooks;
    }

    private function hookhandle($dymic_hooks)
    {
        $matcher = new Matcher();

        $this->_hooks = array_merge($this->defaultHooks(), $dymic_hooks);

        $this->_trace_hook->push($this->_hooks, [__FILE__, __LINE__], "记录最终的hooks");

        $matcher->call($this->_hooks, $this->_message, function (HookStruct $struct, MessageContract $message) {
            $this->executeHook($struct, $message);
        });
    }

    private function executeHook(HookStruct $struct, MessageContract $message)
    {
        HookDispatcher::dispatch(HookFactory::make($this->_config->hook_path, $struct->name), $struct, $message);

        $this->_trace_hook->push($struct->toArray(), [__FILE__, __LINE__], "执行了hook");
    }

    public function getMessage()
    {
        return $this->_message;
    }

    public function getMaterials()
    {
        return $this->_message;
    }

    public function getHooks()
    {
        return $this->_hooks;
    }

    public function getTrace()
    {
        return $this->_trace_collection;
    }

    public function getReplys()
    {
        return $this->_hooks;
    }

    public function response()
    {
        $dymic_hooks = Arr::pullAll($this->_replys, 'hook', 'type');

        $this->hookhandle($dymic_hooks);

        $this->filterMaterial();

        return $this;
    }

}