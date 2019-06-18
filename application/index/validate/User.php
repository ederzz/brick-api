<?php

namespace app\index\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'account'  =>  'require|max:25',
        'phone' => 'require|max:11',
        'password' => 'require|max:25'
    ];

    protected $message  =   [
        'account.require' => '账号必须填写',
        'account.max'     => '账号最多不能超过25个字符',
        'phone.require' => '手机必须填写',
        'phone.max' => '手机号码不正确',
        'password.require' => '密码必须填写',
        'password.max' => '密码不能超过25个字符',
    ];

}