<?php
// +----------------------------------------------------------------------
// | HkCms 登录页
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2021 http://www.hkcms.cn, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 广州恒企教育科技有限公司 <admin@hkcms.cn>
// +----------------------------------------------------------------------

declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\auth\AdminLog;

class Login extends BaseController
{
    protected $layout = ''; // 关闭layout布局

    protected $middleware = [
        'login' => ['only'=>['logout']]
    ];

    /**
     * 登录页/登录操作
     * @return string|void
     */
    public function index()
    {
        if ($this->user->id) {
            return redirect((string)url('/index/index'));
        }
        if ($this->request->isPost()) {
            $data = $this->request->only(['username'=>'','password'=>'','captcha'=>'','url'=>''],'post','trim,htmlspecialchars');
            $this->validate($data,[
                'username|'.__('Username')=>'require|alphaDash|length:3,16',
                'password|'.__('Password')=>'require|min:6',
                'captcha|'.__('Captcha')=>'require|captcha',
            ],[
                'captcha.captcha' => __('Captcha error')
            ]);
            if (empty($data['url'])) {
                $url = '/index/index';
            } else {
                $url = '/'.$data['url'];
            }
            AdminLog::setTitle('Sign In');
            $user = $this->user->login($data['username'], $data['password']);
            if ($user) {
                hook('adminLoginSuccess', $data);
                $this->result(__('Login successfully'), ['url'=>(string)url($url)]);
            } else if ($user===0) {
                $this->result(__('Account is disabled'), [], -1001);
            } else {
                $this->result(__('Username or password error, login failed'), [], -1001);
            }
        }
        $url = input('url');
        $this->view->assign('url',$url);
        return $this->view->fetch();
    }

    /**
     * 验证码
     * @return \think\Response
     */
    public function verify()
    {
        return captcha('adminlogin');
    }

    /**
     * 退出登录
     * @return \think\response\Redirect
     */
    public function logout()
    {
        $this->user->logout();
        return redirect((string)url('/login/index'));
    }
}