<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\Base;
use app\index\model\User as UserModal;
use app\index\model\Project as ProjectModal;
use app\index\model\File as FileModal;
use app\index\model\ProjectTags as ProjectTagsModal;

class Brick extends Base
{
    public function index()
    {
        if ($this->request->isGet()) {
            $category = input('get.category');
            $layout = input('get.layout');
            $stack = input('get.stack');
            $page = input('get.page');

            $data = [];

            if($category) {
                $data['category'] = $category;
            }

            if($layout) {
                $data['layout'] = $layout;
            }

            if($stack) {
                $data['stack'] = $stack;
            }


            $result = ProjectModal::getProjects($data);

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
                $tagResult = ProjectTagsModal::findByIds($tagsIds); // 该页所有的标签信息

                $data = [];

                //var_dump($userResult);
                //var_dump($tagResult);

                foreach ($result as $k => $v) {

                    $userName = '';
                    foreach ($userResult as $kk => $vv) {
                        if($vv->id == $v->user_id) {
                            $userName = $vv->account;
                            break;
                        }
                    }

                    $thisTagsIds = explode(',',$v->tags_id); // 该条数据的标签ID


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
                        'description'=>$v->description,
                        'thumb'=>$v->thumb,
                        'user'=> $userName,
                        'id' => $v->id,
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

    public function getFile()
    {
        if ($this->request->isPost()) {
            $projectName = input('post.projectName');
            $project = ProjectModal::getProjectByName($projectName);

            if ($project) {
                $result = FileModal::getFiles(['project_id' => $project->id]);
                if ($result) {
                    $return = ['code' => 0, 'data' => $result, 'message' => '获取成功'];
                } else {
                    $return = ['code' => 0, 'message' => '暂无初始数据'];
                }
            } else {
                $return = ['code' => 1, 'message' => '没有该项目'];
            }
            return json($return, 200);
        }
    }
}
