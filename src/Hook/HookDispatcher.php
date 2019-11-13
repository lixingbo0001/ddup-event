<?php namespace Ddup\Event\Hook;


use Ddup\Part\Message\MessageContract;
use Ddup\Event\Config\HookStruct;
use Ddup\Event\Contracts\HookInterface;

class HookDispatcher
{

    private static function syncHandle(HookInterface $hanlder, MessageContract $message)
    {
        $hanlder->handle($message);
    }

    private static function asyncHandle(HookInterface $hanlder, HookStruct $option, MessageContract $message)
    {
        $job = (new HookJob($hanlder, $message))->delay((int)$option->delay);

        dispatch($job);
    }

    public static function dispatch(HookInterface $handle, HookStruct $option, MessageContract $message)
    {
        if ($option->is_async) {
            self::asyncHandle($handle, $option, $message);
        } else {
            self::syncHandle($handle, $message);
        }
    }
}

