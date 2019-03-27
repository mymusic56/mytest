<?php
use \Swoft\Route;

/**
 * 配置自定义路由
 */
Route::get("/", "indexController/index");
Route::get('/index', 'indexController/index');
Route::get('/test', function () {
    return '这是一个闭包';
});