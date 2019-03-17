<?php
/**
 * Created by PhpStorm.
 * User: root1
 * Date: 2018/7/5
 * Time: 下午3:57
 */

namespace Ddup\Event\Contracts;


use Ddup\Event\Config\HookStruct;
use Ddup\Part\Message\MessageContract;

interface MatcherCallable
{
    public function callback(HookStruct $struct, MessageContract $message);
}