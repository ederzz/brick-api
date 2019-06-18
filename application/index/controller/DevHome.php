<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\BaseAuth;
use app\index\model\Project as ProjectModal;

class DevHome extends BaseAuth
{
    public function index()
    {
        if ($this->request->isGet()) {
            $data = ['user_id'=>$this->user_id];

            $result = ProjectModal::getMyProject($data);

            if($result) {
                $return = ['code'=>0, 'data'=>$result, 'message'=>'获取成功'];
            }else{
                $return = ['code'=>1, 'message'=>'获取失败'];
            }

            return json($return, 200);
        }
    }
}
