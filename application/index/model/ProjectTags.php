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

    public static function findProjectTagsById($ids)
    {
        $result = self::where('id','in',$ids)->column('name');
        return $result;
    }

    public static function findByIds($ids)
    {
        $result = self::where('id','in',$ids)->select();
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