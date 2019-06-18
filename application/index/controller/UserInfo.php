<?php
namespace app\index\controller;
use app\index\controller\BaseAuth;
use app\index\model\User as UserModel;

class UserInfo extends BaseAuth
{
    public function index()
    {
        if ($this->request->isGet()) {
            $userInfo = UserModel::getUserInfo($this->user_id);

            if($userInfo) {
                $return = ['data' => ['account'=>$userInfo->account],'code'=>0, 'message'=>'获取用户信息成功'];
            }else{
                $return = ['code'=>1, 'message'=>'获取用户信息失败'];
            }

            return json($return, 200);
        }
    }
}