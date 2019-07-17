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
    'brick/getList' => 'Brick/index', // 模块商城
    'wall/create' => 'WallAuth/index', // 创建一个作品
    'wall/save' => 'WallAuth/save', // 创建一个作品
    'wall/getList' => 'Wall/index', // 获取作品列表
    'wall/getMyList' => 'WallAuth/myList', // 获取个人作品
    'wall/getMyWorks' => 'WallAuth/myWorks', // 获取个人作品
    'dev/getList' => 'DevHome/index', // 开发者首页项目列表
    'dev/getTags' => 'DevHome/getTags',
    'dev/create' => 'Dev/createProject',
    'dev/update' => 'Dev/updateProject',
    'dev/checkName' => 'Dev/checkName', // 检查名称是否唯一
    'dev/getFile' => 'Dev/getFile',
    'preview/getFiles' => 'Preview/getFiles', // 通过项目名称数组 获取 文件对象集合
    'dev/updateFile' => 'Dev/updateFile'
];
