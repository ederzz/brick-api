<?php

namespace app\index\controller;
include_once VENDOR_PATH.'aliyun-openapi-php-sdk-master/aliyun-php-sdk-core/Config.php';
use Sts\Request\V20150401 as Sts;
use think\Controller;
use app\index\controller\Base;

class AliyunSts extends Base
{
    public function getInfo()
    {
        if ($this->request->isGet()) {
// 只允许RAM用户使用角色
            \DefaultProfile::addEndpoint('cn-beijing', 'cn-beijing', "Sts", 'sts.cn-beijing.aliyuncs.com');
            $iClientProfile = \DefaultProfile::getProfile('cn-beijing', "LTAI6THNx0kMEZTF", "n2NVQoxmd5SzcCfxyBy3N9Z3gxZsry");
            $client = new \DefaultAcsClient($iClientProfile);
// 指定角色ARN
            $roleArn = "acs:ram::1023052663923509:role/aliyunosstokengeneratorrole"; // acs:ram::1023052663923509:role/aliyuncodepipelinedefaultrole
// 在扮演角色时，添加一个权限策略，进一步限制角色的权限
// 以下权限策略表示拥有可以读取所有OSS的只读权限
            $policy = <<<POLICY
{
  "Statement": [
    {
        "Action": "*",
        "Effect": "Allow",
        "Resource": "*"
    }
  ],
  "Version": "1"
}
POLICY;
            $request = new Sts\AssumeRoleRequest();
// RoleSessionName即临时身份的会话名称，用于区分不同的临时身份
            $request->setRoleSessionName("external-username");
            $request->setRoleArn($roleArn);
            //$request->setPolicy($policy);
            $request->setDurationSeconds(3600);
            try {
                $response = $client->getAcsResponse($request);

                if ($response) {
                    $return = ['code' => 0, 'data' => $response, 'message' => '获取成功'];
                } else {
                    $return = ['code' => 1, 'message' => '获取失败'];
                }

            } catch (ServerException $e) {
                print "Error: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
            } catch (ClientException $e) {
                print "Error: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
            }

            return json($return, 200);
        }
    }
}