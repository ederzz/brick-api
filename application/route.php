<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    'user'=> 'User/login',
    'user/login'=> 'User/login',
    'user/getCode'=> 'User/getCode',
    'user/register'=> 'User/register',
    'user/info' => 'UserInfo/index',
    'wall/getList' => 'Wall/index', // 模块商城
    'dev/getList' => 'DevHome/index', // 开发者首页项目列表
    'dev/create' => 'Dev/createProject',
    'dev/checkName' => 'Dev/checkName', // 检查名称是否唯一
    'dev/getFile' => 'Dev/getFile',
    'preview/getFiles' => 'Preview/getFiles', // 通过项目名称数组 获取 文件对象集合
    'dev/updateFile' => 'Dev/updateFile'
];
