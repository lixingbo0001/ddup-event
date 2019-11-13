<?php namespace Ddup\Event\Hook;


use Ddup\Event\Contracts\HookInterface;
use Illuminate\Support\Str;

class HookFactory
{

    public static function make($prefix, $name):HookInterface
    {
        $className = self::spellingHookClassName($prefix, $name);

        if (!class_exists($className)) {
            throw new \Exception("hook not exists:" . $name . ' in [' . $prefix . ']');
        }

        return new $className;
    }

    private static function spellingHookClassName($prefix, $name)
    {
        return $prefix . '\\' . Str::studly($name) . 'Hook';
    }

}

