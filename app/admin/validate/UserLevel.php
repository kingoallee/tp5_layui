<?php

namespace app\admin\validate;

use think\Validate;

class UserLevel extends Validate
{
    protected $rule = [
        'level_name|会员组名称' => [
            'require' => 'require',
            'max'     => '255',
            'unique'  => 'user_level',
        ],

        'description|描述' => [
            'max' => '255',
        ],

    ];
}