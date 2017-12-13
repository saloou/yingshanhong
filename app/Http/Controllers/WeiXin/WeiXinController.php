<?php

namespace App\Http\Controllers\WeiXin;
use App\Http\Controllers\Controller;

class WeiXinController extends Controller
{

    public function api()
    {
        //获取post数据, 可能存在于 不同的环境 所以要考虑接收函数的使用
        // $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//php:input
        $postStr = file_get_contents("php://input");

        //将接收到的 xml 数据 进行字符串转码 传递另一个变量
        $postStrTemp=iconv("UTF-8", "GB2312//IGNORE", $postStr);

        //写入日志  在同级目录下建立php_log.txt
        //chmod 777 php_log.txt(赋权) chown www php_log.txt(修改主)

        //将转码后的 字符串变量 写入到 'php_log.txt'中
        error_log(var_export($postStrTemp, 1), 3, 'php_log.txt');
        //日志图片

        // 如果接收的数据 不为null （注意：这里判断的字符串变量 不能是转码后的）
        if (!empty($postStr)) {
            /* libxml_disable_entity_loader是防止XML外部实体注入，最好的方法是检查XML的有效性。*/
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                           <ToUserName><![CDATA[%s]]></ToUserName>
                           <FromUserName><![CDATA[%s]]></FromUserName>
                           <CreateTime>%s</CreateTime>
                           <MsgType><![CDATA[%s]]></MsgType>
                           <Content><![CDATA[%s]]></Content>
                           <FuncFlag>0</FuncFlag>
                           </xml>";
            //订阅事件
            if ($postObj->Event == "subscribe") {
                $msgType = "text";
                $contentStr = "欢迎关注映山红影视文化传媒，后端在努力开发中 持续关注我们，将为您奉上最好的影视段子，哈哈";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }


            //语音识别
            if ($postObj->MsgType == "voice") {
                $msgType = "text";
                $contentStr = trim($postObj->Recognition, "。");
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }

            //自动回复
            if (!empty($keyword)) {
                $msgType = "text";
                $contentStr = "感谢你的不离不弃，哈哈！";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            } else {
                echo "Input something...";
            }

        } else {
            echo "";
            exit;
        }
    }
}
