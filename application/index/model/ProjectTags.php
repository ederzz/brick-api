<?php

namespace app\index\model;
use think\Model;

class ProjectTags extends Model
{

    protected
        $autoWriteTimestamp = 'datetime';

    public static function findProjectTags($names)
    {
        $result = self::where('name','in',$names)->select();
        return $result;
    }

    // 创建多条数据
    public static function createProjectTags($datas)
    {
        $projectTags = new ProjectTags;
        $result = $projectTags->saveAll($datas);
        return $result;
    }
}