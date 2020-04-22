<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-21 14:16
 */

namespace app\api\model;


class Theme extends BaseModel
{
    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    /*
     * 关联product，多对多关系
     */
    public function products()
    {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }

    public static function getThemeWithProducts($id)
    {
        $themes = self::with('products,topicImg,headImg')
            ->find($id);
        return $themes;
    }
}