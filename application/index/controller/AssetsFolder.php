<?php
namespace app\index\controller;
use app\index\controller\BaseAuth;
use app\index\model\AssetsFolder as AssetsFolderModal;

class AssetsFolder extends BaseAuth
{
    public function index()
    {
        if ($this->request->isPost()) {
            // $this->user_id
            $name = input('post.name');

            $data = [
                'name'=>$name,
                'user_id'=>$this->user_id
            ];

            $res = AssetsFolderModal::createFolder($data);


            if($res) {
                $return = ['code'=>0, 'message'=>'创建成功'];
            }else{
                $return = ['code'=>1, 'message'=>'创建失败'];
            }

            return json($return, 200);
        }
    }

    public function getList()
    {
        if ($this->request->isGet()) {
            $data = ['user_id'=>$this->user_id];

            $result = AssetsFolderModal::getFolder($data);

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