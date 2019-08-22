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
    'brick/getFile' => 'Brick/getFile', // 模块商城
    'works/create' => 'WorksAuth/index', // 创建一个作品
    'works/save' => 'WorksAuth/save', // 创建一个作品
    'works/getList' => 'Works/index', // 获取作品列表
    'works/getMyList' => 'WorksAuth/myList', // 获取个人作品
    'works/getMyWorks' => 'WorksAuth/myWorks', // 获取个人作品
    'works/info' => 'Works/info', // 获取作品详情
    'dev/getList' => 'DevHome/index', // 开发者首页项目列表
    'dev/getProject' => 'DevHome/getProject',
    'dev/getTags' => 'DevHome/getTags',
    'dev/create' => 'Dev/createProject',
    'dev/update' => 'Dev/updateProject',
    'dev/checkName' => 'Dev/checkName', // 检查名称是否唯一
    'dev/getFile' => 'Dev/getFile',
    'preview/getFiles' => 'Preview/getFiles', // 通过项目名称数组 获取 文件对象集合
    'dev/updateFile' => 'Dev/updateFile',
    'project/getInfo' => 'Project/getInfo', // 获取模块信息
    'folder/create' => 'AssetsFolder/index', // 创建文件夹
    'folder/getList' => 'AssetsFolder/getList', // 创建文件夹
    'getSts' => 'AliyunSts/getInfo', // 获取上传权限
    'assets/saveFiels' => 'AssetsFile/index', // 保存上传的文件路径
    'assets/getFiels' => 'AssetsFile/getFiels'  // 根据文件夹获取文件
];
