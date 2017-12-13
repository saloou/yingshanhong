<?php

namespace App\Http\Controllers;


use App\Http\Proxy\SmsProxy\SmsSingleProxy;
use App\Http\Proxy\SmsProxy\SmsMultiProxy;

use App\Http\Proxy\SmsProxy\SmsVoicePromptProxy;
use App\Http\Proxy\SmsProxy\SmsVoiceVerifyCodeProxy;
use Illuminate\Http\Request;


class SendSmsController extends Controller
{
    protected $smsSingleProxy;
    protected $smsMultiProxy;
    protected $smsVoiceVerifyCodeProxy;
    protected $smsVoicePromptProxy;

    public function __construct(SmsSingleProxy $smsSingleProxy, SmsMultiProxy $smsMultiProxy, SmsVoiceVerifyCodeProxy $smsVoiceVerifyCodeProxy, SmsVoicePromptProxy $smsVoicePromptProxy)
    {
        $this->smsSingleProxy = $smsSingleProxy;
        $this->smsMultiProxy = $smsMultiProxy;
        $this->smsVoiceVerifyCodeProxy = $smsVoiceVerifyCodeProxy;
        $this->smsVoicePromptProxy = $smsVoicePromptProxy;
    }


    public function test()
    {
        $phone = "15940062858";

        $this->smsSingleProxy->test($phone);
//        $this->smsMultiProxy->test();
//        $this->smsVoiceVerifyCodeProxy->test();
//        $this->smsVoicePromptProxy->test();

    }
}
