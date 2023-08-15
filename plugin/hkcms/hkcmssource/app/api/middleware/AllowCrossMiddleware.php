<?php
// +----------------------------------------------------------------------
// | 跨域中间件
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2021 http://www.hkcms.cn, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 广州恒企教育科技有限公司 <admin@hkcms.cn>
// +----------------------------------------------------------------------
declare (strict_types=1);

namespace app\api\middleware;

use app\Request;
use think\exception\HttpResponseException;
use think\facade\Config;
use think\Response;

class AllowCrossMiddleware
{
    protected $header = [
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Max-Age'           => 1800,
        'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers'     => 'Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, X-Token, X-Form-Client',
        'Access-Control-Allow-Origin'      => '*',
    ];

    /**
     * 允许跨域请求
     * @access public
     * @param Request $request
     * @param \Closure $next
     * @param array|null $header
     * @return Response
     */
    public function handle(Request $request, \Closure $next, ? array $header = [])
    {
        $header = !empty($header) ? array_merge($this->header, $header) : $this->header;
        $cookieDomain = Config::get('cookie.domain');
        if (!isset($header['Access-Control-Allow-Origin'])) {
            $origin = $request->header('origin');
            if ($origin && ('' == $cookieDomain || strpos($origin, $cookieDomain))) {
                $header['Access-Control-Allow-Origin'] = $origin;
            } else {
                $header['Access-Control-Allow-Origin'] = '*';
            }
        }
        if ($request->method(true)=='OPTIONS') {
            throw new HttpResponseException(Response::create('', 'html', 204)->header($header));
        }
        return $next($request)->header($header);
    }
}