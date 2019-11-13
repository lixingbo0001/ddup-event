<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午9:17
 */

namespace Ddup\Event\Contracts;

use Ddup\Event\EventReply;

interface EventInterface
{
    public function eventKey();

    public function eventName();

    public function execute($name = null):EventReply;
}