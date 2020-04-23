<?php
/**
 * Created by PhpStorm.
 * User: wangjz
 * Date: 2020-03-18
 * Time: 17:49
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;

class Banner extends BaseController
{


    /**
     * @param $id
     * @return \think\response\Json
     * @throws BannerMissException
     * @throws \think\Exception
     * Note: 获取指定ID的banner信息
     * Url: /banner/:id
     * User: 凸^-^凸
     * Date: 2020-04-15 17:35
     */
    public function getBanner($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $banner = BannerModel::getBannerByID($id);
        # $banner->hidden(['update_time']);  // 隐藏 属性
        # $banner->visible(['update_time']); // 显示 属性
        // get find all select
        if(!$banner){
            throw new BannerMissException('day day up');
        }
        return json($banner);
    }
}