<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

// Banner
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');


// Theme
Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList');
Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');
//Route::group('api/:version/theme',function(){
//    Route::get('', 'api/:version.Theme/getSimpleList');
//    Route::get('/:id', 'api/:version.Theme/getComplexOne');
//    Route::post(':t_id/product/:p_id', 'api/:version.Theme/addThemeProduct');
//    Route::delete(':t_id/product/:p_id', 'api/:version.Theme/deleteThemeProduct');
//});

// Product
Route::get('api/:version/product/recent', 'api/:version.Product/getRecent');
Route::get('api/:version/product/by_category', 'api/:version.Product/getAllInCategory');
Route::get('api/:version/product/by_category/paginate', 'api/:version.Product/getByCategory');
Route::get('api/:version/product/:id', 'api/:version.Product/getOne', [], ['id' => '\d+']);

// Category
Route::get('api/:version/category', 'api/:version.Category/getCategories');
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');


// Token
Route::post('api/:version/token/user', 'api/:version.Token/getToken');

Route::post('api/:version/token/app', 'api/:version.Token/getAppToken');
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');

//Address
Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');
Route::get('api/:version/address', 'api/:version.Address/getUserAddress');

// Order
Route::post('api/:version/order', 'api/:version.Order/placeOrder');
Route::get('api/:version/order/:id', 'api/:version.Order/getDetail', [], ['id' => '\d+']);
Route::put('api/:version/order/delivery', 'api/:version.Order/delivery');

//不想把所有查询都写在一起，所以增加by_user，很好的REST与RESTFul的区别
Route::get('api/:version/order/by_user', 'api/:version.Order/getSummaryByUser');
Route::get('api/:version/order/paginate', 'api/:version.Order/getSummary');

// Pay
Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');
Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');
Route::post('api/:version/pay/re_notify', 'api/:version.Pay/redirectNotify');
Route::post('api/:version/pay/concurrency', 'api/:version.Pay/notifyConcurrency');

return [

];
