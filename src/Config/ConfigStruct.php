<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/9
 * Time: 下午4:00
 */

namespace Ddup\Event\Config;

use Ddup\Part\Struct\StructReadable;

class ConfigStruct extends StructReadable
{
    public $hook_path = 'Ddup\\Event\\Test\\Provider\\Hooks';
    public $material_provider;
    public $events    = [
        'system_event_test' => [
            [
                'name'          => 'test1',
                'is_async'      => 0,
                'delay'         => 0,
                'condition_op'  => null,
                'condition_key' => null,
                'condition_val' => null
            ]
        ]
    ];
}