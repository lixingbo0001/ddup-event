<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/12/18
 * Time: 下午5:19
 */

namespace Ddup\Event\Test\Provider;


use Ddup\Part\Row\RowContainerInterface;

class UserRow implements RowContainerInterface
{

    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function attr($name)
    {
        return 'test';
    }

    public function toArray()
    {
        return ['name' => 'test', 'id' => $this->id];
    }

    public function getId()
    {
        return $this->id;
    }
}