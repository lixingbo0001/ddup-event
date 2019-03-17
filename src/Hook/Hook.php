<?php namespace Ddup\Event\Hook;


use Ddup\Event\Contracts\MatcherCallable;
use Ddup\Event\Matcher;
use Ddup\Part\Message\MessageContract;
use Ddup\Event\Config\HookStruct;
use Ddup\Event\Contracts\HookInterface;
use Illuminate\Support\Str;

class Hook implements MatcherCallable
{

    private $disptcher;
    private $prefix;

    public function __construct($prefix)
    {
        $this->disptcher = new HookDispatcher();
        $this->prefix    = $prefix;
    }

    public function handle($hooks, MessageContract $message)
    {
        $matcher = new Matcher();

        $matcher->call($hooks, $message, $this);
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

