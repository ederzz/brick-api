<?php

namespace app\index\model;
use think\Model;

class AssetsFolder extends Model
{

    protected
        $autoWriteTimestamp = 'datetime';

    public static function createFolder($data)
    {
        $result = self::create($data);
        return $result -> id;
    }

    public static function getFolder($data)
    {
        $result = self::where($data)
            ->field('name,id')
            ->select();
        return $result;// array , empty array
    }

}