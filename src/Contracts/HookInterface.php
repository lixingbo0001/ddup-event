<?php
/**
 * Created by PhpStorm.
 * User: root1
 * Date: 2018/7/5
 * Time: 下午3:57
 */

namespace Ddup\Event\Contracts;


use Ddup\Part\Message\MessageContract;

interface HookInterface
{
    function handle(MessageContract $message);
}