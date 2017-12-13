<?php


namespace App\Http\Proxy\SmsProxy;

//单发消息类
class SmsSingleProxy
{
    protected $url;
    protected $appId;
    protected $appKey;
    protected $smsTools;

    public function __construct(SmsTools $smsTools)
    {
        //群发和单发 url是不同的地址
        $this->url = "https://yun.tim.qq.com/v5/tlssmssvr/sendsms";
        $this->appId =env('SMS_APP_ID');
        $this->appKey =env('SMS_APP_KEY');
        $this->smsTools=$smsTools;
    }


    public function test($phone)
    {
//        // 普通单发
        //这里的短信内容 必须与 qcloud 短信模版内容 一致
//        $result = $this->send(0, "86", $phone, "{1}为您的登录验证码，请于{2}分钟内填写。如非本人操作，请忽略本短信。", "", "");


        // 指定模板单发
        // 假设模板内容为：测试短信，{1}，{2}，{3}，上学。
        $templId = 61609;
        $params = array("1234", "1");
        $result = $this->sendWithParam("86", $phone, $templId, $params, "", "", "");



        $rsp = json_decode($result);
        var_dump($rsp);
        echo "<br>";

    }


    /**
     * 普通单发，明确指定内容，如果有多个签名，请在内容中以【】的方式添加到信息内容中，否则系统将使用默认签名
     * @param int $type 短信类型，0 为普通短信，1 营销短信
     * @param string $nationCode 国家码，如 86 为中国
     * @param string $phoneNumber 不带国家码的手机号
     * @param string $msg 信息内容，必须与申请的模板格式一致，否则将返回错误
     * @param string $extend 扩展码，可填空串
     * @param string $ext 服务端原样返回的参数，可填空串
     * @return string json string { "result": xxxxx, "errmsg": "xxxxxx" ... }，被省略的内容参见协议文档
     */
    function send($type, $nationCode, $phoneNumber, $msg, $extend = "", $ext = "")
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
        $data->type = (int)$type;
        $data->msg = $msg;
        $data->sig = hash("sha256",
            "appkey=" . $this->appKey . "&random=" . $random . "&time=" . $curTime . "&mobile=" . $phoneNumber, FALSE);
        $data->time = $curTime;
        $data->extend = $extend;
        $data->ext = $ext;
        return $this->smsTools->sendCurlPost($wholeUrl, $data);
    }

    /**
     * 指定模板单发
     * @param string $nationCode 国家码，如 86 为中国
     * @param string $phoneNumber 不带国家码的手机号
     * @param int $templId 模板 id
     * @param array $params 模板参数列表，如模板 {1}...{2}...{3}，那么需要带三个参数
     * @param string $sign 签名，如果填空串，系统会使用默认签名
     * @param string $extend 扩展码，可填空串
     * @param string $ext 服务端原样返回的参数，可填空串
     * @return string json string { "result": xxxxx, "errmsg": "xxxxxx"  ... }，被省略的内容参见协议文档
     */
    function sendWithParam($nationCode, $phoneNumber, $templId = 0, $params, $sign = "", $extend = "", $ext = "") {
        $random = $this->smsTools->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appId . "&random=" . $random;

        // 按照协议组织 post 包体
        $data = new \stdClass();
        $tel = new \stdClass();
        $tel->nationcode = "".$nationCode;
        $tel->mobile = "".$phoneNumber;

        $data->tel = $tel;
        $data->sig = $this->smsTools->calculateSigForTempl($this->appKey, $random, $curTime, $phoneNumber);
        $data->tpl_id = $templId;
        $data->params = $params;
        $data->sign = $sign;
        $data->time = $curTime;
        $data->extend = $extend;
        $data->ext = $ext;
        return $this->smsTools->sendCurlPost($wholeUrl, $data);
    }


}
