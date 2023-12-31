<?php
// +----------------------------------------------------------------------
// | HkCms 前台路由加载完成事件
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2021 http://www.hkcms.cn, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 广州恒企教育科技有限公司 <admin@hkcms.cn>
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace app\index\event;

class RouteLoaded
{
    public function handle($handle)
    {
        // 加载插件标签库
        load_taglib();
    }
}