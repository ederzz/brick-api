<?php
namespace app\index\controller;
use app\index\model\WorksTags;
use think\Controller;
use app\index\controller\Base;
use app\index\model\Works as WorksModal;
use app\index\model\User as UserModal;
use app\index\model\WorksTags as WorksTagsModal;


class Wall extends Base
{
    public function index()
    {
        if ($this->request->isGet()) {

            $data = [];


            $result = WorksModal::getWorks($data);

            if($result) {
                // 获取到数据里面所有的用户和标签ID 然后去重
                $userIds = [];
                $tagsIds = [];

                foreach ($result as $k => $v) {
                    array_push($userIds,$v->user_id);
                    $tagsIds = array_merge($tagsIds,explode(',',($v->tags_id)));
                }

                $userIds = array_unique($userIds,SORT_REGULAR);
                $tagsIds = array_unique($tagsIds,SORT_REGULAR);

                $userResult = UserModal::getUserInfos($userIds);
                $tagResult = WorksTags::findByIds($tagsIds); // 该页所有的标签信息

                $data = [];

                foreach ($result as $k => $v) {
                    $findUser = array_filter($userResult,function($vv) use($v){
                        return $vv->id == $v->user_id;
                    });
                    if($findUser) {
                        $userName = $findUser[0]->account;
                    }else{
                        $userName = '';
                    }

                    //var_dump($v->id);

                    $thisTagsIds = explode(',',$v->tags_id); // 该条数据的标签ID

                    //var_dump($thisTagsIds);


                    $findTags = array_filter($tagResult,function($vv) use($thisTagsIds){
                        //return true;
                        return array_search($vv->id , $thisTagsIds) !== FALSE;
                    });

                    $findTagsName = [];
                    foreach ($findTags as $kk=>$vv) {
                       array_push($findTagsName,$vv->name);
                    }

                    $item = [
                        'name'=>$v->name,
                        'code'=>$v->code,
                        'user'=> $userName,
                        'tags'=> $findTagsName,
                    ];
                    array_push($data,$item);
                }


                $return = ['code'=>0, 'data'=>$data, 'message'=>'获取成功'];
            }else if(is_array($result) && empty($result)) {
                $return = ['code'=>0, 'message'=>'没有查询到数据'];
            }else{
                $return = ['code'=>1, 'message'=>'获取失败'];
            }

            return json($return, 200);

        }
    }
}
