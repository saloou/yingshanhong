<?php

// Works well with php5.3 and php5.6.

namespace App\Http\Proxy\SmsProxy;


class SmsVoiceVerifyCodeProxy
{
    protected $url;
    protected $appId;
    protected $appKey;
    protected $smsTools;

    public function __construct(SmsTools $smsTools)
    {
        $this->url = "https://yun.tim.qq.com/v5/tlsvoicesvr/sendvoice";
        $this->appId =env('SMS_APP_ID');
        $this->appKey =env('SMS_APP_KEY');
        $this->smsTools = $smsTools;
    }

    function test()
    {
        $phoneNumber1 = "15940062858";

        //语音验证码发送
        $result = $this->send("86", $phoneNumber1, "1234", 2, "");
        $rsp = json_decode($result);
        var_dump($rsp);
        echo "<br>";
    }

    /**
     * 语言验证码发送
     * @param string $nationCode 国家码，如 86 为中国
     * @param string $phoneNumber 不带国家码的手机号
     * @param string $msg 信息内容，必须与申请的模板格式一致，否则将返回错误
     * @param intger $playtimes 信息内容，必须与申请的模板格式一致，否则将返回错误
     * @param string $ext 服务端原样返回的参数，可填空串
     * @return string json string { "result": xxxxx, "errmsg": "xxxxxx" ... }，被省略的内容参见协议文档
     */
    function send($nationCode, $phoneNumber, $msg, $playtimes = 2, $ext = "")
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
        $data->msg = $msg;
        $data->playtimes = $playtimes;
        $data->sig = hash("sha256",
            "appkey=" . $this->appKey . "&random=" . $random . "&time=" . $curTime . "&mobile=" . $phoneNumber, FALSE);
        $data->time = $curTime;
        $data->ext = $ext;
        return $this->smsTools->sendCurlPost($wholeUrl, $data);
    }
}

