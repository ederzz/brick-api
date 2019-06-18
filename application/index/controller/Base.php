<?php
namespace app\index\controller;
use think\Controller;
use think\Request;

class Base extends Controller
{
    public function _initialize() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description, Authorization');
    }
}
