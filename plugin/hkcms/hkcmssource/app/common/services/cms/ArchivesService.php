<?php
// +----------------------------------------------------------------------
// | 文档服务
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2023 http://www.hkcms.cn, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 广州恒企教育科技有限公司 <admin@hkcms.cn>
// +----------------------------------------------------------------------
declare (strict_types=1);

namespace app\common\services\cms;

use app\common\dao\cms\ArchivesDao;
use app\common\services\BaseService;
use think\facade\Cache;

/**
 * @mixin ArchivesDao
 */
class ArchivesService extends BaseService
{
    /**
     * 初始化
     * @param ArchivesDao $dao
     */
    public function __construct(ArchivesDao $dao)
    {
        $this->dao = $dao;
    }

    /**
     * 清理缓存
     * @param array $categoryIds
     * @return void
     */
    public function clearCache(array $categoryIds)
    {
        $totalSub = Cache::get('category_doc_total_sub');
        $totalCount = Cache::get('get_doc_total');
        if (is_array($totalSub)) {
            $newArr = [];
            foreach ($totalSub as $key=>$value) {
                if (!in_array($key, $categoryIds)) {
                    $newArr[$key] = $value;
                }
            }
            Cache::set('category_doc_total_sub', $newArr);
        }
        if (is_array($totalCount)) {
            $newArr = [];
            foreach ($totalCount as $key=>$value) {
                if (!in_array($key, $categoryIds)) {
                    $newArr[$key] = $value;
                }
            }
            Cache::set('get_doc_total', $newArr);
        }
        Cache::tag('archives_content_tag')->clear();
    }
}