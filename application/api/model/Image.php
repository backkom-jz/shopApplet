<?php

namespace app\api\model;

class Image extends BaseModel
{
    protected $hidden = ['id','from','delete_time','update_time'];

    protected function getUrlAttr($value, $data)
    {
        return self::prefixImgUrl($value, $data);
    }
}
