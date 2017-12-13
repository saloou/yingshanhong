<?php


namespace App\Http\Proxy\SmsProxy;


class SmsMultiProxy
{
    protected $url;
    protected $appId;
    protected $appKey;
    protected $smsTools;

    public function __construct(SmsTools $smsTools)
    {
        //群发和单发 url是不同的地址
        $this->url = "https://yun.tim.qq.com/v5/tlssmssvr/sendmultisms2";
        $this->appId =env('SMS_APP_ID');
        $this->appKey =env('SMS_APP_KEY');
        $this->smsTools = $smsTools;
    }

    public function test()
    {
        $phoneNumber1 = "15940062858";
        $phoneNumber2 = "15802490274";
        $templId = 61609;

//        // 普通群发
//        $phoneNumbers = array($phoneNumber1, $phoneNumber2);
//        $result = $this->send(0, "86", $phoneNumbers, "{1}为您的登录验证码，请于{2}分钟内填写。如非本人操作，请忽略本短信。", "", "");
//        $rsp = json_decode($result);
//        var_dump($rsp);
//        echo "<br>";

        // 指定模板群发，模板参数沿用上文的模板 id 和 $params
        $phoneNumbers = array($phoneNumber1, $phoneNumber2);
        $params = array("6789", "9");
        $result = $this->sendWithParam("86", $phoneNumbers, $templId, $params, "", "", "");
        $rsp = json_decode($result);
        var_dump($rsp);
        echo "<br>";


    }

    /**
     * 普通群发，明确指定内容，如果有多个签名，请在内容中以【】的方式添加到信息内容中，否则系统将使用默认签名
     * 【注意】海外短信无群发功能
     * @param int $type 短信类型，0 为普通短信，1 营销短信
     * @param string $nationCode 国家码，如 86 为中国
     * @param string $phoneNumbers 不带国家码的手机号列表
     * @param string $msg 信息内容，必须与申请的模板格式一致，否则将返回错误
     * @param string $extend 扩展码，可填空串
     * @param string $ext 服务端原样返回的参数，可填空串
     * @return string json string { "result": xxxxx, "errmsg": "xxxxxx" ... }，被省略的内容参见协议文档
     */
    function send($type, $nationCode, $phoneNumbers, $msg, $extend = "", $ext = "")
    {
        $random = $this->smsTools->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appId . "&random=" . $random;
        $data = new \stdClass();
        $data->tel = $this->smsTools->phoneNumbersToArray($nationCode, $phoneNumbers);
        $data->type = $type;
        $data->msg = $msg;
        $data->sig = $this->smsTools->calculateSig($this->appKey, $random, $curTime, $phoneNumbers);
        $data->time = $curTime;
        $data->extend = $extend;
        $data->ext = $ext;
        return $this->smsTools->sendCurlPost($wholeUrl, $data);
    }

    /**
     * 指定模板群发
     * 【注意】海外短信无群发功能
     * @param string $nationCode 国家码，如 86 为中国
     * @param array $phoneNumbers 不带国家码的手机号列表
     * @param int $templId 模板 id
     * @param array $params 模板参数列表，如模板 {1}...{2}...{3}，那么需要带三个参数
     * @param string $sign 签名，如果填空串，系统会使用默认签名
     * @param string $extend 扩展码，可填空串
     * @param string $ext 服务端原样返回的参数，可填空串
     * @return string json string { "result": xxxxx, "errmsg": "xxxxxx" ... }，被省略的内容参见协议文档
     */
    function sendWithParam($nationCode, $phoneNumbers, $templId, $params, $sign = "", $extend = "", $ext = "")
    {
        $random = $this->smsTools->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appId . "&random=" . $random;
        $data = new \stdClass();
        $data->tel = $this->smsTools->phoneNumbersToArray($nationCode, $phoneNumbers);
        $data->sign = $sign;
        $data->tpl_id = $templId;
        $data->params = $params;
        $data->sig = $this->smsTools->calculateSigForTemplAndPhoneNumbers(
            $this->appKey, $random, $curTime, $phoneNumbers);
        $data->time = $curTime;
        $data->extend = $extend;
        $data->ext = $ext;
        return $this->smsTools->sendCurlPost($wholeUrl, $data);
    }

}