<?php

namespace app\index\controller;

use think\Controller;
use app\index\controller\Base;
use app\index\model\Project as ProjectModal;
use app\index\model\File as FileModal;

class Preview extends Base
{
    public function getFiles()
    {
        // 通过项目名称数组 获取 文件对象集合
        if ($this->request->isPost()) {
            $names = input('post.names/a');
            $projects = ProjectModal::getProjectByNames($names);

            if($projects) {
                $ids = [];
                foreach($projects as $key=>$project){
                    array_push($ids,$project->id);
                }

                if(count($ids) > 0) {
                    $files = FileModal::getFileByProjectIds($ids);
                    if($files) {
                        $data = [];
                        foreach($projects as $project) {
                            $data[$project->name] = [];
                            foreach ($files as $file) {
                                if($file->project_id === $project->id) {
                                    //$fieldFile = ['type'=>$file->file_type,'content'=>$file->content];
                                    //array_push($data[$project->name],$fieldFile);
                                    $data[$project->name][$file->file_type] = $file->content;
                                    $data[$project->name]['stack'] = $project->stack;
                                }
                            }
                        }
                        $return = ['code' => 0, 'data' => $data, 'message' => '获取成功'];
                    }else{
                        $return = ['code' => 1, 'message' => '引入的模块是空模块'];
                    }
                }else{
                    $return = ['code' => 1, 'message' => '获取引入的模块失败'];
                }
            }else{
                $return = ['code' => 1, 'message' => '没有找到相关模块'];
            }
            return json($return, 200);
        }
    }
}