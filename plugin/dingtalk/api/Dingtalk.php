<?php

namespace plugin\dingtalk\api;

use plugin\admin\app\model\Option;
use support\exception\BusinessException;

class Dingtalk
{

    /**
     * Option表的name字段值
     */
    const SETTING_OPTION_NAME = 'dingtalk_setting';

    /**
     * @param $from
     * @param $to
     * @param $subject
     * @param $content
     * @return void
     */
    public static function send($from, $to, $subject, $content)
    {
        $mailer = static::getMailer();
        call_user_func_array([$mailer, 'setFrom'], (array)$from);
        call_user_func_array([$mailer, 'addAddress'], (array)$to);
        $mailer->Subject = "=?UTF-8?B?".base64_encode($subject)."?=";
        $mailer->isHTML(true);
        $mailer->Body = $content;
        $mailer->send();
    }

    /**
     * 按照模版发送
     * @param string|array $to
     * @param $templateName
     * @param array $templateData
     * @return void
     * @throws BusinessException
     * @throws Exception
     */
    public static function sendByTemplate($to, $templateName, array $templateData = [])
    {
        $emailTemplate = Option::where('name', "email_template_$templateName")->value('value');
        $emailTemplate = $emailTemplate ? json_decode($emailTemplate, true) : null;
        if (!$emailTemplate) {
            throw new BusinessException('模版不存在');
        }
        $subject = $emailTemplate['subject'];
        $content = $emailTemplate['content'];
        if ($templateData) {
            $search = [];
            foreach ($templateData as $key => $value) {
                $search[] = '{' . $key . '}';
            }
            $content = str_replace($search, array_values($templateData), $content);
        }
        $config = static::getConfig();
        static::send($config['From'] ?? '', $to, $subject, $content);
    }

    /**
     * @return array|null
     */
    public static function getConfig(): ?array
    {
        $config = Option::where('name', static::SETTING_OPTION_NAME)->value('value');
        return $config ? json_decode($config, true) : null;
    }

}