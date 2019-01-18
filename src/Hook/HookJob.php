<?php namespace Ddup\Event\Hook;

use Ddup\Part\Message\MessageContract;
use Ddup\Event\Contracts\HookInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HookJob implements ShouldQueue
{
    use  InteractsWithQueue, Queueable, SerializesModels;

    public $tries   = 1;
    public $timeout = 30;

    public $hook;

    public $message;

    public function __construct(HookInterface $hook, MessageContract $message)
    {
        $this->hook    = $hook;
        $this->message = $message;
    }

    public function handle()
    {
        $this->hook->handle($this->message);
    }
}

