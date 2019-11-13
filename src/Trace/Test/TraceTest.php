<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2019/11/13
 * Time: 下午1:25
 */

namespace Ddup\Event\Trace\Test;

use Ddup\Part\Test\TestCase;
use Ddup\Event\Trace\Trace;
use Ddup\Event\Trace\TraceCollection;

class TraceTest extends TestCase
{
    private $_trace_hook;
    private $_trace_collection;

    public function test_change()
    {
        $this->_trace_hook       = new Trace('hook');
        $this->_trace_collection = new TraceCollection();

        $this->_trace_collection->push($this->_trace_hook);

        $this->_trace_hook->push([
            'event' => 'subscribe'
        ], __FILE__, __LINE__);


        Helper::change($this->_trace_hook);

        dump($this->_trace_hook);

        dump($this->_trace_collection->toArray());

        $this->assertEquals(2, count($this->_trace_hook->toArray()));
        $this->assertEquals(2, count($this->_trace_collection->get('hook')->toArray()));
    }


}