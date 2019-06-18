<?php

namespace app\index\controller;

use think\Controller;
use app\index\controller\BaseAuth;
use app\index\model\Project as ProjectModal;
use app\index\model\File as FileModal;

class Dev extends BaseAuth
{
    public function getFile()
    {
        if ($this->request->isPost()) {
            $projectName = input('post.projectName');
            $project = ProjectModal::getProjectByName($projectName);

            if ($project) {
                if ($project->user_id === $this->user_id) {
                    $result = FileModal::getFiles(['project_id' => $project->id]);
                    if ($result) {
                        $return = ['code' => 0, 'data' => $result, 'message' => '获取成功'];
                    } else {
                        $return = ['code' => 0, 'message' => '暂无初始数据'];
                    }
                } else {
                    $return = ['code' => 1, 'message' => '你不是该项目作者'];
                }
            } else {
                $return = ['code' => 1, 'message' => '没有该项目'];
            }
            return json($return, 200);
        }
    }

    public function getFiles()
    {
        // 通过项目名称数组 获取 文件对象集合
        if ($this->request->isPost()) {
            $projectNames = input('post.projectNames');
        }
    }

    public function checkName()
    {
        if ($this->request->isPost()) {
            $name = input('post.name'); // 名称是唯一的
            $result = ProjectModal::getProjectByName($name);
            if($result) {
                $return = ['code' => 1, 'message' => '项目名称重复'];
            }else {
                $return = ['code' => 0, 'message' => '项目名称合法'];
            }

            return json($return, 200);
        }
    }

    public function createProject()
    {
        if ($this->request->isPost()) {
            $name = input('post.name'); // 名称是唯一的
            $category = input('post.category');
            $layout = input('post.layout');
            $tags = input('post.tags');
            $description = input('post.description');

            if ($this->user_id) {
                $resultProject = ProjectModal::getProjectByName($name);
                if ($resultProject) {
                    $return = ['code' => 1, 'message' => '该项目已经存在'];
                } else {
                    $data = ['name' => $name,
                        'category' => $category,
                        'layout' => $layout,
                        'tags_id' => $tags,
                        'description' => $description,
                        'user_id' => $this->user_id,
                    ];

                    $result = ProjectModal::createProject($data);

                    if ($result) {
                        $return = ['code' => 0, 'message' => '创建成功'];
                    } else {
                        $return = ['code' => 1, 'message' => '创建失败'];
                    }
                }
            } else {
                $return = ['code' => 1, 'message' => '请登录'];
            }

            return json($return, 200);
        }
    }

    public function updateFile()
    {
        if ($this->request->isPost()) {
            $projectName = input('post.projectName');
            $html = input('post.html');
            $css = input('post.css');
            $js = input('post.js');

            // 查找项目名称 获取user_id project_id
            // 判断是不是当前用户的项目
            // 在file查找html css js 文件 如果不存在就创建 如果存在就更新

            $project = ProjectModal::getProjectByName($projectName);

            if ($project) {
                if ($project->user_id === $this->user_id) {
                    $htmlInfo = FileModal::getFileByProject($project->id, 'html');
                    $cssInfo = FileModal::getFileByProject($project->id, 'css');
                    $jsInfo = FileModal::getFileByProject($project->id, 'js');

                    // $htmlId && $cssId && $jsId 批量更新
                    // !$htmlId && !$cssId && !$jsId 批量新建

                    if ($htmlInfo) {
                        $resHtml = FileModal::updateFile($htmlInfo->id, $html);
                    } else {
                        $resHtml = FileModal::createFile(['project_id' => $project->id, 'file_type' => 'html', 'content' => $html]);
                    }
                    if ($cssInfo) {
                        $resCss = FileModal::updateFile($cssInfo->id, $css);
                    } else {
                        $resCss = FileModal::createFile(['project_id' => $project->id, 'file_type' => 'css', 'content' => $css]);
                    }
                    if ($jsInfo) {
                        $resJs = FileModal::updateFile($jsInfo->id, $js);
                    } else {
                        $resJs = FileModal::createFile(['project_id' => $project->id, 'file_type' => 'js', 'content' => $js]);
                    }

                    if (($resHtml || $resHtml === 0) && ($resCss || $resCss === 0) && ($resJs || $resJs === 0)) {
                        $return = ['code' => 0, 'message' => '保存成功'];
                    } else {
                        $return = ['code' => 1, 'message' => '保存失败'];
                    }
                } else {
                    $return = ['code' => 1, 'message' => '你不是该项目作者'];
                }
            } else {
                $return = ['code' => 1, 'message' => '没有该项目'];
            }

            return json($return, 200);
        }
    }

}
