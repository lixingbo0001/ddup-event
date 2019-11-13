<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2019/11/13
 * Time: 下午12:56
 */

namespace Ddup\Event\Trace;


use Illuminate\Contracts\Support\Arrayable;

class Trace implements Arrayable
{
    private $_items = [];
    private $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function push($data, $file, $title = '')
    {
        $item = new TraceItem($this->_name, $data);

        $item->setFile(is_array($file) ? join("::", $file) : $file);

        $item->setTitle($title);

        $this->_items[] = $item;
    }

    public function info()
    {
        return $this->_items;
    }

    public function toArray()
    {
        $result = [];

        foreach ($this->_items as $item) {
            $result[] = $item->toArray();
        }

        return $result;
    }
}