<?php

namespace app\index\model;
use think\Model;

class Project extends Model {

    protected
    $autoWriteTimestamp = 'datetime';

    public static function createProject($data) {
        $result = self::create($data);
        return $result -> id;
    }

    public static function updateProject($data) {
        $result = self::update($data);
        return $result -> id;
    }

    public static function getProjects($data)
    {
        $result = self::where($data)
            ->order('create_time', 'desc')
            ->field('name,category,layout,stack,description,thumb')
            ->select();
        return $result;// array , empty array
    }

    public static function getMyProject($data)
    {
        $result = self::where($data)
            ->order('create_time', 'desc')
            ->field('id,name,category,layout,stack,description,thumb,slots,tags_id')
            ->select();
        return $result;
    }

    public static function getProjectByName($name)
    {
        $result = self::get(['name' => $name]);
        return $result; // null , object
    }

    public static function getProjectByNames($names)
    {
        $result = self::where('name', 'in' ,$names)->select();
        return $result; // null , object
    }
}