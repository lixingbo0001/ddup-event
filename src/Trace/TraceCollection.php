<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2019/11/13
 * Time: 下午12:56
 */

namespace Ddup\Event\Trace;


use Illuminate\Contracts\Support\Arrayable;

class TraceCollection implements Arrayable
{
    private $_list = [];

    public function push(Trace &$trace)
    {
        $this->_list[$trace->getName()] = $trace;

        return $this;
    }

    public function toArray()
    {
        $result = [];

        foreach ($this->_list as $trace) {
            if ($trace instanceof Arrayable) {
                $result[] = $trace->toArray();
            } else {
                $result[] = $trace;
            }
        }

        return $result;
    }

    /**
     * @param $name
     * @return Trace
     */
    public function get($name)
    {
        if ($this->hasTrace($name)) {
            return new Trace('empty');
        }

        return $this->_list[$name];
    }

    private function hasTrace($name)
    {
        if ($name instanceof Trace) {
            $name = $name->getName();
        }

        return !array_key_exists($name, $this->_list);
    }
}