<?php
/**
 * Created by PhpStorm.
 * User: wangjz
 * Date: 2020-03-17
 * Time: 11:33
 */

namespace app\sample\controller;


use think\Controller;
use think\Request;

class Test extends Controller
{
    public function index(){
        return 'hello world!';
    }

    public function hello($id,$name){
        return $id.'|'.$name;
    }

    public function helloTest2(){
       $id = $this->request->param('id');
       echo $id;
    }

    public function helloTest3(Request $request){
        $all = $request->param();
        print_r($all);
    }

}