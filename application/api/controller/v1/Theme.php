<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-21 14:14
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;

class Theme extends BaseController
{

    /**
     * @param string $ids
     * @return array|\PDOStatement|string|\think\Collection
     * @throws ThemeException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @url /theme?ids=id1,id2,id3
     * Note: 获取简单主题列表
     * User: 凸^-^凸
     * Date: 2020-04-21 14:46
     */
    public function getSimpleList($ids = '')
    {

        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::with('topicImg,headImg')
            ->select($ids);

        if ($result->isEmpty()) {
            throw new ThemeException();
        }
        return $result;

    }

    /**
     * @param $id
     * @return \think\response\Json
     * @throws ThemeException
     * @throws \think\Exception
     * Note: 获取主题详情
     * User: 凸^-^凸
     * Date: 2020-04-21 17:28
     */
    public function getComplexOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if ($theme->isEmpty()) {
            throw new ThemeException();
        }
        return json($theme->hidden(['products.summary']));
    }
}