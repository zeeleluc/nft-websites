<?php
namespace App\Template;

use App\Object\BaseObject;

abstract class Configuration extends BaseObject
{
    public function layouts()
    {
        return [
            'default',
            'error',
            'async',
        ];
    }

    public function views()
    {
        return [
            'terminal' => [
            ],
            'async' => [
                'tasks',
                'sports',
            ],
            'website' => [
                'home',
                'sport',
            ],
        ];
    }
}
