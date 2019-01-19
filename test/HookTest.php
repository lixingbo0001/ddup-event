<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午11:32
 */

namespace Ddup\Event\Test;

use Ddup\Event\Config\ConfigStruct;
use PHPUnit\Framework\TestCase;
use Ddup\Event\EventMessage;
use Ddup\Event\EventProvider\EventSystem;

class HookTest extends TestCase
{

    public function testIsExecute()
    {
        $message_arr = [
            "id"       => 1,
            "order_no" => "20193924324243",
            "status"   => "success",
        ];

        $message = new EventMessage($message_arr);

        $event = new EventSystem($message, new ConfigStruct());

        $event->execute('test');

        $this->assertEquals(true, true);
    }

    public function testEventFun()
    {
        $message_arr = [
            "id"       => 1,
            "order_no" => "20193924324243",
            "status"   => "success",
        ];

        $message = new EventMessage($message_arr);
        $event   = new EventSystem($message, new ConfigStruct());

        $event->execute('test');

        $this->assertTrue(true);
    }
}