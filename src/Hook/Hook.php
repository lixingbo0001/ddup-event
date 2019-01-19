<?php namespace Ddup\Event\Hook;


use Ddup\Event\Matcher;
use Ddup\Part\Message\MessageContract;
use Ddup\Event\Config\EventConfig;
use Ddup\Event\Config\HookStruct;
use Ddup\Event\Contracts\HookInterface;
use Illuminate\Support\Str;

class Hook
{

    private $disptcher;
    private $prefix;

    public function __construct($prefix)
    {
        $this->disptcher = new HookDispatcher();
        $this->prefix    = $prefix;
    }

    public function handle(EventConfig $config, MessageContract $message)
    {
        $matcher = new Matcher();

        $matcher->isMatched($config, $message, $this);
    }

    public function callback(HookStruct $struct, MessageContract $message)
    {
        $this->disptcher->dispatch(self::make($struct->name), $struct, $message);
    }

    private function make($name):HookInterface
    {
        $className = self::spellingHookClassName($name);

        if (!class_exists($className)) {
            throw new \Exception("hook not exists:" . $name . ' in [' . $this->prefix . ']');
        }

        return new $className;
    }

    private function spellingHookClassName($name)
    {
        return $this->prefix . '\\' . Str::studly($name) . 'Hook';
    }

}

