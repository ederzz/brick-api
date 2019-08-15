<?php
namespace app\index\controller;
use app\index\controller\BaseAuth;
use app\index\model\AssetsFile as AssetsFileModal;

class AssetsFile extends BaseAuth
{
    public function index()
    {
        if ($this->request->isPost()) {
            $urls = input('post.urls/a');
            $folder_id = input('post.folder_id');

            $data = [];

            foreach ($urls as $k => $v) {
                $data[] = [
                    'url' => $v,
                    'folder_id'=>$folder_id
                ];
            }

            $res = AssetsFileModal::createFiels($data);


            if($res) {
                $return = ['code'=>0, 'message'=>'创建成功'];
            }else{
                $return = ['code'=>1, 'message'=>'创建失败'];
            }

            return json($return, 200);
        }
    }

    public function getFiels()
    {
        if ($this->request->isPost()) {

            $folder_id = input('post.folder_id');

            $data = ['folder_id'=>$folder_id];

            $result = AssetsFileModal::getFiels($data);

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