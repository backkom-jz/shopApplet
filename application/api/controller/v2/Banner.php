<?php
/**
 * Created by PhpStorm.
 * User: wangjz
 * Date: 2020-03-18
 * Time: 17:49
 */

namespace app\api\controller\v2;


class Banner
{

    public function getBanner($id)
    {
        return '^_^ this is v2'.$id;
    }
}