<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\Base;
use app\index\model\Project as ProjectModal;

class Brick extends Base
{
    public function index()
    {
        if ($this->request->isGet()) {
            $category = input('get.category');
            $layout = input('get.layout');
            $page = input('get.page');

            $data = [];

            if($category) {
                $data['category'] = $category;
            }

            if($layout) {
                $data['layout'] = $layout;
            }


            $result = ProjectModal::getProject($data);

            if($result) {
                $return = ['code'=>0, 'data'=>$result, 'message'=>'获取成功'];
            }else if(is_array($result) && empty($result)) {
                $return = ['code'=>0, 'message'=>'没有查询到数据'];
            }else{
                $return = ['code'=>1, 'message'=>'获取失败'];
            }

            return json($return, 200);
        }
    }
}
