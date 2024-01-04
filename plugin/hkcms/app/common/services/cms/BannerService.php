<?php
// +----------------------------------------------------------------------
// | 站点模块资源服务
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2023 http://www.hkcms.cn, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 广州恒企教育科技有限公司 <admin@hkcms.cn>
// +----------------------------------------------------------------------
declare (strict_types=1);

namespace app\common\services\cms;

use app\common\dao\cms\BannerDao;
use app\common\services\BaseService;

/**
 * @mixin BannerDao
 */
class BannerService extends BaseService
{
    /**
     * 初始化
     * @param BannerDao $dao
     */
    public function __construct(BannerDao $dao)
    {
        $this->dao = $dao;
    }
}