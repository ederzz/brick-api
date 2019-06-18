<?php

namespace app\index\model;
use think\Model;

class File extends Model {

    protected
        $autoWriteTimestamp = 'datetime';

    public static function createFile($data) {
        $result = self::create($data);
        return $result -> id;
    }

    public static function updateFile($id,$content) {
        $result = self::where('id', $id)
            ->update(['content' => $content]);
        return $result;
    }

    public static function getFileByProject($project_id,$file_type)
    {
        $result = self::get(['project_id' => $project_id,'file_type'=>$file_type]);
        return $result;
    }

    public static function getFileByProjectIds($ids)
    {
        $result = self::where('project_id', 'in' ,$ids)->select();
        return $result;
    }

    public static function getFiles($data)
    {
        $result = self::where($data)
            ->field('file_type,content')
            ->select();
        return $result;
    }
}