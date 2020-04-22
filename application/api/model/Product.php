<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-21 14:15
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $autoWriteTimestamp = 'datetime';
    # pivot tp默认的多对多关系的中间表
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'];

    /**
     * 图片属性
     */
    public function images()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    /*
     * @param $count
     * 获取最近新品
     */
    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }


    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }
}