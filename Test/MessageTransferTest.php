<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/12/18
 * Time: 下午5:18
 */

namespace Ddup\Event\Test;


use Ddup\Event\EventMessage;
use Ddup\Event\Test\Provider\UserMookObj;
use Ddup\Event\Test\Provider\UserRow;

class MessageTransferTest extends \PHPUnit\Framework\TestCase
{

    public function test_object()
    {
        $obj    = new UserMookObj();
        $messge = new EventMessage($obj);

        $this->assertNotNull($obj->age);

        $this->assertEquals($obj->age, $messge->get('age'));
    }

    public function test_row()
    {
        $id = 178;

        $row = new UserRow($id);

        $message = new EventMessage($row);

        $this->assertNotNull($message->get('id'));

        $this->assertEquals($row->getId(), $message->get('id'));
    }

}