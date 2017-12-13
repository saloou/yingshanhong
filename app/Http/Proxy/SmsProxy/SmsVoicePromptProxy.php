<?php


namespace App\Http\Proxy\SmsProxy;


class SmsVoicePromptProxy
{
    protected $url;
    protected $appId;
    protected $appKey;
    protected $smsTools;

    public function __construct(SmsTools $smsTools)
    {
        $this->url = "https://yun.tim.qq.com/v5/tlsvoicesvr/sendvoiceprompt";
        $this->appId =env('SMS_APP_ID');
        $this->appKey =env('SMS_APP_KEY');
        $this->smsTools = $smsTools;
    }

    function test()
    {
        $phoneNumber1 = "15940062858";

        //语音通知发送
        //msg 必须与 qCloud 语音短息模版 一致
        $result = $this->send("86", $phoneNumber1, "2", "欢迎注册映山红影视文化的会员", "", "");
        $rsp = json_decode($result);
        var_dump($rsp);
        echo "<br>";
    }

    /**
     * 语言通知发送
     * @param string $nationCode 国家码，如 86 为中国
     * @param string $phoneNumber 不带国家码的手机号
     * @param string $prompttype 语音类型目前固定值，2
     * @param string $msg 信息内容，必须与申请的模板格式一致，否则将返回错误
     * @param string $playtimes 播放次数
     * @param string $ext 服务端原样返回的参数，可填空串
     * @return string json string { "result": xxxxx, "errmsg": "xxxxxx" ... }，被省略的内容参见协议文档
     */
    function send($nationCode, $phoneNumber, $prompttype, $msg, $playtimes = 2, $ext = "")
    {
        $random = $this->smsTools->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appId . "&random=" . $random;

        // 按照协议组织 post 包体
        $data = new \stdClass();
        $tel = new \stdClass();
        $tel->nationcode = "" . $nationCode;
        $tel->mobile = "" . $phoneNumber;

        $data->tel = $tel;
        $data->promptfile = $msg;
        $data->prompttype = $prompttype;//固定值
        $data->playtimes = $playtimes;
        $data->sig = hash("sha256",
            "appkey=" . $this->appKey . "&random=" . $random . "&time=" . $curTime . "&mobile=" . $phoneNumber, FALSE);
        $data->time = $curTime;
        $data->ext = $ext;
        return $this->smsTools->sendCurlPost($wholeUrl, $data);
    }
}