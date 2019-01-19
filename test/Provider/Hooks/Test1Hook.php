<?php

namespace Ddup\Event\Test\Provider\Hooks;


use Ddup\Event\Contracts\HookInterface;
use Ddup\Logger\Cli\CliLogger;
use Ddup\Part\Message\MessageContract;

class Test1Hook implements HookInterface
{
    public function handle(MessageContract $message)
    {
        $logger = new CliLogger();

        $logger->info('成功来到' . __CLASS__);
    }
}