<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午11:42
 */

namespace Ddup\Event\Translator;


use Ddup\Part\Message\MessageContract;

class MsgTranslaterXml extends MessageContract
{

    private $arr;

    public function __construct($xml)
    {
        $this->arr = $this->xmlObjToArray(simplexml_load_string($xml));
    }

    private function xmlObjToArray($obj)
    {
        $result = [];

        foreach ($obj as $child) {

            $result[$child->getName()] = (string)$child;

        }
        return $result;
    }

    public function get($attr, $def = null)
    {
        return array_get($this->arr, $attr, $def);
    }

    public function set($attr, $value)
    {
        array_set($this->arr, $attr, $value);
    }

    public function toArray()
    {
        return $this->arr;
    }

}