<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-21 17:54
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

class Product extends BaseController
{

    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);

        if ($products->isEmpty()) {
            throw new ProductException();
        }

        $products = $products->hidden([
            'summary'
        ]);
        return $products;
    }

    /*
     * @param $id
     * @url: api/:version/product/by_category
     * Note: 获取某分类下商品
     * User: 凸^-^凸
     * Date: 2020-04-22 17:29
     */
    public function getAllInCategory($id)
    {
        (new  IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryId($id);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        return $products;
    }

    /*
     * @param $id
     * @url: api/:version/product/:id
     * Note: 获取商品详情
     * User: 凸^-^凸
     * Date: 2020-04-22 17:29
     */
    public function getOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $product = ProductModel::getProductDetail($id);
        if ($product->isEmpty()) {
            throw new ProductException();
        }
        return $product;
    }
}