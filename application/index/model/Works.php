<?php

namespace app\index\model;
use think\Model;

class Works extends Model
{

    protected
        $autoWriteTimestamp = 'datetime';

    public static function createWorks($data)
    {
        $result = self::create($data);
        return $result->id;
    }

    public static function saveWorks($data)
    {
        $result = self::update($data);
        return $result->id;
    }

    public static function getWorks($data)
    {
        $result = self::where($data)
            ->order('create_time', 'desc')
            ->field('name,code,thumb,user_id,tags_id,id')
            ->select();
        return $result;// array , empty array
    }

    public static function getMyWorks($data)
    {
        $result = self::where($data)
            ->order('create_time', 'desc')
            ->field('name,code,thumb,id')
            ->select();
        return $result;// array , empty array
    }

    public static function getWorksById($id)
    {
        $result = self::get(['id' => $id]);
        return $result; // null , object
    }

}