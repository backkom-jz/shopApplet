<?php
/**
 * Created by PhpStorm.
 * User: wangjz
 * Date: 2020-03-23
 * Time: 23:14
 */

namespace app\api\model;


class Banner extends BaseModel
{
    protected $hidden = ['id','delete_time','update_time'];

    public function items()
    {
        return $this->hasMany("BannerItem", "banner_id", "id");
    }

    public static function getBannerByID($id)
    {
        /***查询数据库***/

        # $result = Db::query('select * from banner_item where banner_id=?',[$id]);

        # $result = Db::table('banner_item')->where('banner_id','=',$id)->select();
        # 表达式 数组法 闭包
        /*
        $result = Db::table('banner_item')
            ->fetchSql()
            ->where(function ($query) use ($id) {
                $query->where('banner_id', '=', $id);
            })
            ->select();
        */
        # ORM Object Relation Mapping 对象映射关系
        # 模型
        /***查询数据库 end***/
        $banner = self::with(['items', 'items.img'])->find($id);
        return $banner;
    }
}