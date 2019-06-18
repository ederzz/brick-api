<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\User as UserModel;
use app\index\model\Token as TokenModel;

class Auth extends Base
{

    public function refreshtokenold()
    {
        if ($this->request->isGet()) {
            $header = $this->request->header();
            //var_dump($header);
            $Bearer_token = $header['authorization'];

            if(!$Bearer_token) {
            }

            $token = substr($Bearer_token, 7);

            $tokenInfo = RefreshtokenModel::getTokenInfo($token);

            if($tokenInfo) {
                $newToken = $token.'1';
                $refreshTokenInfo = RefreshtokenModel::refreshToken($token,$newToken);
                if($refreshTokenInfo) {

                    // 缓存新token
                    cache($newToken, $tokenInfo->user_id, 7200);

                    $data = ['token' => $newToken];
                    $return = ['data' => $data,'code'=>0, 'message'=>'刷新成功'];
                    return json($return, 200);
                }
            }else{
                // token 不在数据库 前端需要重新登录
                header('HTTP/1.1 401 Unauthorized');
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode(['code'=>1000, 'message'=>'没有登录']));
            }

        }

    }

    public function refreshtoken()
    {
        // 用 localstorage.refreshtoken 放入 authorization
        // refreshtoken 是数据库的token
        // token 是缓存里的
        // 用 authorization 的 refreshtoken 获取 token 放到缓存里面
        if ($this->request->isGet()) {
            $header = $this->request->header();
            //var_dump($header);
            $Bearer_token = $header['authorization'];

            if(!$Bearer_token) {
                $return = ['code'=>2, 'message'=>'缺少请求参数'];
                return json($return, 200);
            }

            $token = substr($Bearer_token, 7);

            $tokenInfo = TokenModel::getTokenInfo($token);

            if($tokenInfo) {
                //$newRefreshtoken = md5(uniqid(mt_rand(), true));
                //$refreshTokenInfo = RefreshtokenModel::updateRefreshtoken($refreshtoken,$newRefreshtoken);
                // 缓存新token
                $interimToken = md5(uniqid(mt_rand(), true));
                cache($interimToken, $tokenInfo->user_id, 7200);
                $data = [
                    'token' => $interimToken
                ];

                $return = ['data' => $data,'code'=>0, 'message'=>'用户信息'];

                return json($return, 200);
            }else{
                // token 不在数据库
                $return = ['code'=>1, 'message'=>'登录过期2'];
                return json($return, 200);
            }
        }
    }

    public function refreshtoken2()
    {
        // 用 localstorage.refreshtoken 放入 authorization
        // refreshtoken 是数据库的token
        // token 是缓存里的
        // 用 authorization 的 refreshtoken 获取 token 放到缓存里面
        if ($this->request->isGet()) {
            $header = $this->request->header();
            //var_dump($header);
            $Bearer_token = $header['authorization'];

            if(!$Bearer_token) {
                $return = ['code'=>2, 'message'=>'缺少请求参数'];
                return json($return, 200);
            }

            $token = substr($Bearer_token, 7);

            $tokenInfo = TokenModel::getTokenInfo($token);

            if($tokenInfo) {
                //$newRefreshtoken = md5(uniqid(mt_rand(), true));
                //$refreshTokenInfo = RefreshtokenModel::updateRefreshtoken($refreshtoken,$newRefreshtoken);
                // 缓存新token
                $interimToken = md5(uniqid(mt_rand(), true));
                cache($interimToken, $tokenInfo->user_id, 7200);
                $data = [
                    'token' => $interimToken
                ];

                $return = ['data' => $data,'code'=>0, 'message'=>'用户信息'];

                return json($return, 200);
            }else{
                // token 不在数据库
                header('HTTP/1.1 401 Unauthorized');
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode(['code'=>1000, 'message'=>'没有登录']));
            }
        }
    }

    public function info()
    {
        // 前端：刷新网页 如果有token 获取用户信息
        // 根据token返回用户信息 成功：页面进入登录状态 失败：清除token处于非登录状态

        // 后端：如果token有缓存 获取用户ID ，没有缓存 去数据库 获取ID后刷新缓存
        // 如果数据库没有获取到用户信息 返回 登录失败信息
        // 根据ID返回用户信息

        if ($this->request->isGet()) {
            $header = $this->request->header();
            //var_dump($header);
            $Bearer_token = $header['authorization'];

            if(!$Bearer_token) {
                $return = ['code'=>2, 'message'=>'缺少请求参数'];
                return json($return, 200);
            }

            $token = substr($Bearer_token, 7);

            $user_id = cache($token);

            if(!$user_id) {
                $tokenInfo = TokenModel::getTokenInfo($token);

                if($tokenInfo) {
                    $newToken = $token.'1';
                    $refreshTokenInfo = TokenModel::refreshToken($token,$newToken);
                    if($refreshTokenInfo) {
                        // 缓存新token
                        cache($newToken, $tokenInfo->user_id, 7200);
                        $user_id = $tokenInfo->user_id;
                        $token = $newToken;
                    }else{
                        // 缓存失败
                        $return = ['code'=>1, 'message'=>'登录过期'];
                        return json($return, 200);
                    }
                }else{
                    // token 不在数据库
                    $return = ['code'=>1, 'message'=>'登录过期'];
                    return json($return, 200);
                }
            }
            $userInfo = UserModel::getUserInfo($user_id);

            $data = [
                'account' => $userInfo->account,
                'token' => $token
            ];

            $return = ['data' => $data,'code'=>0, 'message'=>'用户信息'];

            return json($return, 200);

        }

    }
}
