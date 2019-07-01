<?php

namespace app\index\model;
use think\Model;

class WorksTags extends Model
{

    protected
        $autoWriteTimestamp = 'datetime';

    public static function findWorksTags($names)
    {
        $result = self::where('name','in',$names)->select();
        return $result;
    }

    public static function findByIds($ids)
    {
        $result = self::where('id','in',$ids)->select();
        return $result;
    }

    // 创建多条数据
    public static function createWorksTags($datas)
    {
        $worksTags = new WorksTags;
        $result = $worksTags->saveAll($datas);
        return $result;
    }
}