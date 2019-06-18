<?php

namespace app\index\model;
use think\Model;

class User extends Model
{
    //protected $table = 'project';

    protected $autoWriteTimestamp = 'datetime';

    public static function register($data)
    {
        $result = self::create($data);
        return $result->id;
    }

    public static function saveToken($data)
    {
        $result = self::create($data);
        return $result->id;
    }

    public static function getUserInfo($id)
    {
        $result = self::get(['id' => $id]);
        return $result;
    }

    public static function getUserInfos($ids)
    {
        $result = self::where('id','in',$ids)->select();
        return $result;
    }

    public static function login($account,$password)
    {
        $result = self::get(['account' => $account,'password' => $password]);
        return $result;
    }

    public static function findAccount($account)
    {
        $result = self::get(['account' => $account]);
        return $result; // null || object
    }

    public static function findPhone($phone)
    {
        $result = self::get(['phone' => $phone]);
        return $result; // null || object
    }
}