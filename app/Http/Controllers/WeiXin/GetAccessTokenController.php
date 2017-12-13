<?php

namespace App\Http\Controllers\WeiXin;
include 'WeiXinConstant .php';
use App\Http\Controllers\Controller;

class GetAccessTokenController extends Controller
{
    //主入口
    public function getAccessToken()
    {
        //判断access_token文件是否存在
        if ($this->exists_token()) {
            //判断access_token文件创建时间是否过期
            if ($this->expire_token()) {
                $access_token = $this->get_accessToken();
                unlink('access_token.txt');
                file_put_contents('access_token.txt', $access_token);
            } else {
                $access_token = file_get_contents('access_token.txt');
            }
        } else {
            $access_token = $this->get_accessToken();
            file_put_contents('access_token.txt', $access_token);
        }
        return $access_token;
    }

    //判断文件是否存在函数
    private function exists_token()
    {
        if (file_exists('access_token.txt')) {
            return true;
        } else {
            return false;
        }
    }

    //判断文件创建时间是否过期
    private function expire_token()
    {
        $ctime = filectime('access_token.txt');
        if ((time() - $ctime) >= 7000) {
            return true;
        } else {
            return false;
        }
    }

    //获取微信服务器 access_token值
    private function get_accessToken()
    {
//curl 开始
        $ch = curl_init();
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . APPID . '&secret=' . APPSECRET;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);
//curl 结束

        $access_token = json_decode($output, true)['access_token'];
        return $access_token;


    }


}

