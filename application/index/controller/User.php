<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\User as UserModel;
use app\index\model\Token as TokenModel;

class User extends Base
{
    public function login()
    {
        if ($this->request->isPost()) {
            $account = input('post.account');
            $password = input('post.password');

            $userInfo = UserModel::login($account, md5($password.'av'));

            if($userInfo) {
                $id = $userInfo->id;
                $token = md5(uniqid(mt_rand(), true));

                $token_id = TokenModel::updateTokenByUserId($id,$token);

                if($token_id) {
                    $interimToken = md5(uniqid(mt_rand(), true));
                    $data = [
                        'token' => $interimToken,
                        'refreshToken' => $token
                    ];

                    // 设置缓存数据
                    cache($interimToken, $id, 7200);

                    $return = ['data' => $data,'code'=>0, 'message'=>'登录成功'];

                    return json($return, 200);
                }else{
                    $return = ['code'=>1, 'message'=>'登录失败'];
                }

            }else{

                $return = ['code'=>1, 'message'=>'登录失败'];
            }

            return json($return, 200);
        }

    }

    public function logout(){
        if ($this->request->isGet()) {
            $header = $this->request->header();
            //var_dump($header);
            $Bearer_token = $header['authorization'];

            if($Bearer_token) {
                $token = substr($Bearer_token, 7);
                cache($token, NULL);
            }

            $return = ['code'=>0, 'message'=>'退出成功'];
            return json($return, 200);
        }
    }

    // 用户注册
    public function register() {
        if ($this->request->isPost()) {
            $account = input('post.account');
            $phone = input('post.phone');
            $password = input('post.password');
            $code = input('post.code');

            $cacheCode = cache('code'.$phone); // 获取缓存验证码

            // 验证码错误
            if($code != $cacheCode) {
                return json(['code'=>1, 'message'=>'验证码错误'], 200);
            }

            $validateData = [
                'account' => $account,
                'phone' => $phone,
                'password' => $password
            ];

            // 验证数据
            $validate = $this->validate($validateData, 'User');
            if($validate !== true){
                $return = ['code'=>1, 'message'=>$validate];
                return json($return, 200);
            }

            // 账号是否注册
            $findAccount = UserModel::findAccount($account);
            if($findAccount) {
                return json(['code'=>1, 'message'=>'账号已注册'], 200);
            }

            // 手机是否注册
            $findPhone = UserModel::findPhone($phone);
            if($findPhone) {
                return json(['code'=>1, 'message'=>'手机已注册'], 200);
            }

            $registerData = [
                'account' => $account,
                'phone' => $phone,
                'password' =>md5($password.'av')
            ];

            // 添加会员信息
            $id = UserModel::register($registerData);

            // 添加成功
            if($id) {
                $token = md5(uniqid(mt_rand(), true));

                $tokenData = [
                    'token' => $token,
                    'user_id' => $id
                ];

                $token_id = TokenModel::saveToken($tokenData);

                if($token_id) {
                    $interimToken = md5(uniqid(mt_rand(), true));
                    $data = [
                        'token' => $interimToken,
                        'refreshToken' => $token
                    ];

                    // 设置缓存数据
                    cache($interimToken, $id, 7200);

                    $return = ['data' => $data,'code'=>0, 'message'=>'注册成功'];

                    return json($return, 200);
                }
            }else{
                // 添加失败
                return json(['code'=>1, 'message'=>'注册失败'], 200);
            }
        }
    }

    // 用户账号是否存在
    public function hasAccount()
    {
        if ($this->request->isPost()) {
            $account = input('post.account');
            $res = UserModel::findAccount($account);
            if($res) {
                return json(['code'=>1, 'message'=>'账号已注册'], 200);
            }else{
                return json(['code'=>0, 'message'=>'账号未注册'], 200);
            }
        }
    }

    // 手机号是否存在
    public function hasPhone()
    {
        if ($this->request->isPost()) {
            $phone = input('post.phone');
            $res = UserModel::findAccount($phone);
            if($res) {
                return json(['code'=>1, 'message'=>'手机已注册'], 200);
            }else{
                return json(['code'=>0, 'message'=>'手机未注册'], 200);
            }
        }
    }

    // 获取验证码
    public function getCode()
    {
        if ($this->request->isPost()) {
            $phone = input('post.phone');
            $code = rand(1000,9999);
            cache('code'.$phone,$code,3600); // 缓存验证码一个小时

            // test
            // return json(['code'=>0, 'message'=>'发送成功'.$code], 200);

            $sms = new \aliyunsms\Sms();
            $res = $sms::sendSms($phone,$code);
            if($res->Code === 'OK') {
                return json(['code'=>0, 'message'=>'发送成功'], 200);
            }else{
                return json(['data'=>['errorCode'=>$res->Code],'code'=>1, 'message'=>'发送失败'], 200);
            }
        }
    }

    // 验证码是否正确
    public function validateCode()
    {
        if ($this->request->isPost()) {
            $code = input('post.code');
            $phone = input('post.phone');
            $cacheCode = cache('code'.$phone); // 获取缓存验证码

            if($code != $cacheCode) {
                return json(['code'=>1, 'message'=>'验证码错误'], 200);
            }else{
                return json(['code'=>0, 'message'=>'验证成功'], 200);
            }
        }
    }
}
