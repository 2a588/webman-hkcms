<?php

namespace plugin\dingtalk\app\admin\controller;

use plugin\admin\app\model\Option;
use plugin\dingtalk\api\Dingtalk;
use plugin\dingtalk\app\admin\model\Template;
use plugin\dingtalk\app\admin\service\DingTalkRobotService;
use support\exception\BusinessException;
use support\Request;
use support\Response;
use function view;

/**
 * 钉钉设置
 */
class SettingController
{

    /**
     * 邮件设置页
     * @return Response
     */
    public function index()
    {
        return view('setting/index');
    }

    /**
     * 获取设置
     * @return Response
     */
    public function get(): Response
    {
        $name = Dingtalk::SETTING_OPTION_NAME;
        $setting = Option::where('name', $name)->value('value');
        $setting = $setting ? json_decode($setting, true) : [
            'Host' => 'smtp.qq.com',
            'Username' => '',
            'Password' => '',
            'SMTPSecure' => 'ssl',
            'Port' => 465,
            'From' => '',
        ];
        return json(['code' => 0, 'msg' => 'ok', 'data' => $setting]);
    }

    /**
     * 更改设置
     * @param Request $request
     * @return Response
     */
    public function save(Request $request): Response
    {
        $data = [
            'AccessToken' => $request->post('AccessToken'),
            'Secret' => $request->post('Secret'),
        ];
        $value = json_encode($data);
        $name = Dingtalk::SETTING_OPTION_NAME;
        $option = Option::where('name', $name)->first();
        if ($option) {
            Option::where('name', $name)->update(['value' => $value]);
        } else {
            $option = new Option();
            $option->name = $name;
            $option->value = $value;
            $option->save();
        }
        return json(['code' => 0, 'msg' => 'ok']);
    }

    /**
     * 邮件测试
     * @param Request $request
     * @return Response
     */
    public function test(Request $request): Response
    {
        $option = Option::where('name', Dingtalk::SETTING_OPTION_NAME)->value('value');
        if (!$option) {
            return json(['code' => 403, 'msg' => '请先配置签名']);
        }

        $jsonArr = json_decode($option,true);
        $args = [
            'accessToken' => $jsonArr['AccessToken'],
            'secret' => $jsonArr['Secret'],
            'title' => $request->post('Title', '机器人标题'),
            'message' => $request->post('Content', '这是一个测试内容'),
        ];
        DingTalkRobotService::dingTalkRobot($args);
        return json(['code' => 0, 'msg' => 'ok', 'data' => $option]);
    }

}
