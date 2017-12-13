<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;


class WXTokenController extends Controller
{
    //主入口函数
    /*
     * 第一、在微信公众平台 基础配置里 点击token认证
     * 第二、微信服务器 向本入口发送 数字签证信息
     * 第三、本入口 接收到数据信息后 将数据进行 对比（TOKEN）
     */

    public function api()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        //这里需要 与 公众平台 基本配置里的token一致
        $token = 'wangxun';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

}
