<?php
    namespace app\index\controller;
use think\Controller;

class Page extends Controller
{
    public function index()
{
    return $this->fetch();
}
}
