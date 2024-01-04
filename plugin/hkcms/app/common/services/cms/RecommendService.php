<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2023 http://www.hkcms.cn, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 广州恒企教育科技有限公司 <admin@hkcms.cn>
// +----------------------------------------------------------------------
declare (strict_types=1);

namespace app\common\services\cms;

use app\common\dao\cms\RecommendDao;
use app\common\services\BaseService;

/**
 * @mixin RecommendDao
 */
class RecommendService extends BaseService
{
    /**
     * 初始化
     * @param RecommendDao $dao
     */
    public function __construct(RecommendDao $dao)
    {
        $this->dao = $dao;
    }
}