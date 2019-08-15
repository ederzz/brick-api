<?php

namespace app\index\controller;

use think\Controller;
use app\index\controller\Base;
use app\index\model\Project as ProjectModal;
use app\index\model\File as FileModal;
use app\index\model\ProjectTags as ProjectTagsModal;

class Project extends Base
{
    public function getInfo()
    {
        if ($this->request->isPost()) {
            $projectName = input('post.projectName');
            $project = ProjectModal::getProjectByName($projectName);
            if($project) {
                $return = ['code'=>0, 'data'=>$project, 'message'=>'获取成功'];
            }else{
                $return = ['code'=>1, 'message'=>'获取失败'];
            }

            return json($return, 200);
        }
    }
}