<?php

namespace app\http\middleware;

class CROS
{
    public function handle($request, \Closure $next)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: POST,GET');
        if($request->isOptions()){
            exit();
        }
    }
}
