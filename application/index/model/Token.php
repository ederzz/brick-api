<?php

namespace app\index\model;
use think\Model;

class Token extends Model
{
    //protected $table = 'project';

    protected $autoWriteTimestamp = 'datetime';

    public static function saveToken($data)
    {
        $result = self::create($data);
        return $result->id;
    }

    public static function getTokenInfo($token)
    {
        $result = self::get(['token' => $token]);
        return $result;
    }

    public static function getTokenByUserId($user_id)
    {
        $result = self::get(['user_id' => $user_id]);
        return $result;
    }

    public static function updateTokenByUserId($user_id,$token)
    {
        $result = self::where('user_id', $user_id)
            ->update(['token' => $token]);
        return $result;
    }

    public static function updateToken($token,$newToken)
    {
        $result = self::where('token', $token)
            ->update(['token' => $newToken]);
        return $result;
    }
}