<?php

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'level_id|会员等级' => [
            'require' => 'require',
        ],
        'email|邮箱账号' => [
            'require' => 'require',
            'min'     => '5',
            'max'     => '100',
            'unique'  => 'user',
        ],
        'mobile|联系电话' => [
            'unique'  => 'user',
        ],
        'username|用户名' => [
            'unique'  => 'user',
        ],
    ];
}