<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/27
 * Time: 22:49
 */

namespace App\Controller;


use Swoole\Http\Request;

class IndexController
{
    public function index(Request $request)
    {
        return "你好，这是index().\r\n";
    }
}