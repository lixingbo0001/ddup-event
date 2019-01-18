<?php namespace Ddup\Event\Hook;


use Ddup\Part\Message\MessageContract;
use Ddup\Event\Config\ConfigStruct;
use Ddup\Event\Contracts\HookInterface;

class HookDispatcher
{

    private function syncHandle(HookInterface $hanlder, MessageContract $message)
    {
        $hanlder->handle($message);
    }

    private function asyncHandle(HookInterface $hanlder, ConfigStruct $option, MessageContract $message)
    {
        $job = (new HookJob($hanlder, $message))->delay((int)$option->delay);

        dispatch($job);
    }

    public function dispatch(HookInterface $handle, ConfigStruct $option, MessageContract $message)
    {
        if ($option->is_async) {
            $this->asyncHandle($handle, $option, $message);
        } else {
            $this->syncHandle($handle, $message);
        }
    }
}

