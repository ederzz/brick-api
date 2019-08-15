<?php

namespace app\index\model;
use think\Model;

class AssetsFile extends Model
{

    protected
        $autoWriteTimestamp = 'datetime';

    public static function createFiels($datas)
    {
        $assetsFile = new AssetsFile;
        $result = $assetsFile->saveAll($datas);
        return $result;
    }

    public static function getFiels($data)
    {
        $result = self::where($data)
            ->field('url,id')
            ->select();
        return $result;// array , empty array
    }

}