<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午9:17
 */

namespace Ddup\Event\Contracts;

use Ddup\Part\Message\MessageContract;


interface EventKeyInterface
{
    public function eventKey();

    public function init(EventInterface $event, MessageContract $message);
}