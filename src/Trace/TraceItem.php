<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2019/11/13
 * Time: 下午12:56
 */

namespace Ddup\Event\Trace;


use Illuminate\Contracts\Support\Arrayable;

class TraceItem implements Arrayable
{
    private $_name;
    private $_datetime;
    private $_data;
    private $_file;
    private $_title;

    public function __construct($name, $data)
    {
        $this->_name     = $name;
        $this->_data     = $data;
        $this->_datetime = date('Y-m-d H:i:s');
    }

    public function setFile($file)
    {
        $this->_file = $file;
    }

    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function toArray()
    {
        return [
            'name'     => $this->_name,
            'title'    => $this->_title,
            'file'     => $this->_file,
            'datetime' => $this->_datetime,
            'data'     => $this->_data
        ];
    }
}