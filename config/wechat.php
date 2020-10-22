<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 14:28
 */

return [
    // 小程序app_id
    'app_id' => 'wxf25e63e396d5c92e',
//    'app_id' => 'wx426b3015555a46be',
    // 小程序app_secret
    'app_secret' => 'cedc7607fdb85bb023f5aef348beab89',
//    'app_secret' => '01c6d59a3f9024db6336662ac95c8e74',

    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",

    'mch_id' => '1225312702',
    'notify_url' => 'http://shoptest.test:8080/api/v1/pay/notify',
    'key' => 'e10adc3949ba59abbe56e057f20f883e',
];