<?php
// +----------------------------------------------------------------------
// | HkCms 路由
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2021 http://www.hkcms.cn, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 广州恒企教育科技有限公司 <admin@hkcms.cn>
// +----------------------------------------------------------------------

use \think\facade\Route;
use app\api\middleware\AllowCrossMiddleware;
use app\api\middleware\SiteStatusMiddleware;
use app\api\middleware\ApiLoginMiddleware;
use think\Response;

Route::group(function () {
    Route::get('/', 'Index/index');
    Route::post('auth/login', 'user.Login/login')->option([
        '_title'=>'账号密码登录'
    ]);
    // 需要登录的API
    Route::group(function () {
        Route::get('user/details', 'user.User/details')->option([
            '_title'=>'获取用户详情'
        ]);
    })->middleware(ApiLoginMiddleware::class);
})->middleware(AllowCrossMiddleware::class)
    ->middleware(SiteStatusMiddleware::class);

Route::miss(function () {
}, 'options')->middleware(AllowCrossMiddleware::class);

// 触发路由标签位
hook('apiRoute');