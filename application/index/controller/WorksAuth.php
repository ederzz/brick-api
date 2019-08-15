<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\BaseAuth;
use app\index\model\Works as WorksModal;
use app\index\model\WorksTags as WorksTagsModal;

class WorksAuth extends BaseAuth
{
    public function index()
    {
        if ($this->request->isPost()) {
            // 创建作品
            $name = input('post.name'); // 作品名称
            //$collect = input('post.collect'); // 作品集
            $tags = input('post.tags/a'); // 标签
            $code = input('post.code'); // json 内容
            $thumb = input('post.thumb');

            $errorMessage = null;
            if (!$this->user_id) {
                $errorMessage = '请登录';
            }else if(!$name) {
                $errorMessage = '请填写作品名称';
            }else if(!$tags) {
                $errorMessage = '请填写标签';
            }else if(!$code) {
                $errorMessage = '请填写模块JSON数据';
            }

            if (!$errorMessage) {

                $tagsIds = []; // 作品关联的标签ID
                $newTags = []; // 要创建的标签
                $newTagsData = []; // 要创建的标签数据
                // 查找标签
                $tagsInfo = WorksTagsModal::findWorksTags($tags);
                // 已经存在的标签不用创建 直接push ID 到 $tagsIds
                if($tagsInfo) {
                    foreach ($tags as $k=>$v) {
                        $exist = false; // 标签是否已经存在
                        foreach ($tagsInfo as $kk=>$vv) {
                            if($vv->name == $v) {
                                $exist = $vv->id;
                            }
                        }
                        if($exist) {
                            // 标签已经存在
                            array_push($tagsIds,$exist); // 已经存在的ID
                        }else{
                            // 标签不存在
                            array_push($newTags,$v); // 新的标签
                        }
                    }
                }else{
                    // 如果没有找到 所以的标签都是新标签
                    $newTags = $tags;
                }

                if($newTags) {
                    // 有新标签
                    // 添加标签 并且返回标签ID
                    foreach($newTags as $key=>$tag){
                        array_push($newTagsData,['name' => $tag]);
                    }
                    $tagsResults = WorksTagsModal::createWorksTags($newTagsData);
                    foreach ($tagsResults as $key=>$tag) {
                        array_push($tagsIds,$tag->id); // 新的ID
                    }
                }

                $tags_id = join(',',$tagsIds); // 标签IDs逗号分隔

                $data = ['name' => $name,
                    'tags_id' => $tags_id,
                    //'collect' => $collect,
                    'code' => $code,
                    'user_id' => $this->user_id,
                    'thumb' => $thumb
                ];

                $result = WorksModal::createWorks($data);

                if ($result) {
                    $return = ['code' => 0, 'data'=> $result, 'message' => '创建成功'];
                } else {
                    $return = ['code' => 1, 'message' => '创建失败'];
                }
            } else {
                $return = ['code' => 1, 'message' => $errorMessage];
            }

            return json($return, 200);
        }
    }

    public function save()
    {
        if ($this->request->isPost()) {
            // 保存作品
            $id = input('post.id'); // 作品名称
            $name = input('post.name'); // 作品名称
            //$collect = input('post.collect'); // 作品集
            $tags = input('post.tags/a'); // 标签
            $code = input('post.code'); // json 内容
            $thumb = input('post.thumb');

            $errorMessage = null;
            if (!$this->user_id) {
                $errorMessage = '请登录';
            }else if(!$id) {
                $errorMessage = '没有找到要修改的作品';
            }else if(!$name) {
                $errorMessage = '请填写作品名称';
            }else if(!$tags) {
                $errorMessage = '请填写标签';
            }else if(!$code) {
                $errorMessage = '请填写模块JSON数据';
            }

            if (!$errorMessage) {

                $tagsIds = []; // 作品关联的标签ID
                $newTags = []; // 要创建的标签
                $newTagsData = []; // 要创建的标签数据
                // 查找标签
                $tagsInfo = WorksTagsModal::findWorksTags($tags);
                // 已经存在的标签不用创建 直接push ID 到 $tagsIds
                if($tagsInfo) {
                    foreach ($tags as $k=>$v) {
                        $exist = false; // 标签是否已经存在
                        foreach ($tagsInfo as $kk=>$vv) {
                            if($vv->name == $v) {
                                $exist = $vv->id;
                            }
                        }
                        if($exist) {
                            // 标签已经存在
                            array_push($tagsIds,$exist); // 已经存在的ID
                        }else{
                            // 标签不存在
                            array_push($newTags,$v); // 新的标签
                        }
                    }
                }else{
                    // 如果没有找到 所以的标签都是新标签
                    $newTags = $tags;
                }

                if($newTags) {
                    // 有新标签
                    // 添加标签 并且返回标签ID
                    foreach($newTags as $key=>$tag){
                        array_push($newTagsData,['name' => $tag]);
                    }
                    $tagsResults = WorksTagsModal::createWorksTags($newTagsData);
                    foreach ($tagsResults as $key=>$tag) {
                        array_push($tagsIds,$tag->id); // 新的ID
                    }
                }

                $tags_id = join(',',$tagsIds); // 标签IDs逗号分隔

                $data = [
                    'id' => $id,
                    'name' => $name,
                    'tags_id' => $tags_id,
                    //'collect' => $collect,
                    'code' => $code,
                    'thumb' => $thumb
                ];

                $result = WorksModal::saveWorks($data);

                if ($result) {
                    $return = ['code' => 0, 'message' => '修改成功'];
                } else {
                    $return = ['code' => 1, 'message' => '修改失败'];
                }
            } else {
                $return = ['code' => 1, 'message' => $errorMessage];
            }

            return json($return, 200);
        }
    }

    public function myList()
    {
        if ($this->request->isGet()) {

            $data = ['user_id'=>$this->user_id];


            $result = WorksModal::getMyWorks($data);

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

    public function myWorks()
    {
        if ($this->request->isGet()) {

            $id = input('get.id'); // 名称是唯一的

            if($this->user_id) {

                $result = WorksModal::getWorksById($id);

                $thisTagsIds = explode(',',$result->tags_id); // 该条数据的标签ID
                $tagResult = WorksTagsModal::findByIds($thisTagsIds); // 标签信息

                $findTagsName = [];
                foreach ($tagResult as $kk=>$vv) {
                    array_push($findTagsName,$vv->name);
                }

                $data = [
                    'name'=>$result->name,
                    'code'=>$result->code,
                    'thumb'=>$result->thumb,
                    'tags'=> $findTagsName,
                ];

                if($result) {
                    $return = ['code'=>0, 'data'=>$data, 'message'=>'获取成功'];
                }else if(is_array($result) && empty($result)) {
                    $return = ['code'=>0, 'message'=>'没有查询到数据'];
                }else{
                    $return = ['code'=>1, 'message'=>'获取失败'];
                }

            }else{
                $return = ['code'=>1, 'message'=>'请登录'];
            }

            return json($return, 200);

        }
    }
}
