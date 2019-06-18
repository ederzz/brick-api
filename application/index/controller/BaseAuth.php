<?php
namespace app\index\controller;
use think\Controller;

class BaseAuth extends Controller
{
    public function _initialize() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description, Authorization');



        if ($this->request->isGet() || $this->request->isPost()) {
            $header = $this->request->header();
            //var_dump($header);
            $Bearer_token = $header['authorization'];



            if(!$Bearer_token) {
                header('HTTP/1.1 401 Unauthorized');
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode(['code'=>1000, 'message'=>'没有登录']));
            }

            $token = substr($Bearer_token, 7);

            $user_id = cache($token);

            if(!$user_id) {
                header('HTTP/1.1 401 Unauthorized');
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode(['code'=>1001, 'message'=>'登录过期']));
            }

            $this->token = $token;
            $this->user_id = $user_id;
        }
    }
}
