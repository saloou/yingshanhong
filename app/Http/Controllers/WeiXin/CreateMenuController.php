<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;


class CreateMenuController extends Controller
{

    function createMenu()
    {

        $ACT = new GetAccessTokenController();
        $ACC_TOKEN = $ACT->getAccessToken();

//        $data = '{
//   "button":[
//{
//      "name":"vip专属",
//     "sub_button":[
//      {
//         "type":"click",
//         "name":"vip福利",
//         "key":"fl"
//      },
//      {
//         "type":"click",
//         "name":"正在直播",
//         "key":"zzzb"
//      },
//      {
//         "type":"click",
//         "name":"视频干货",
//         "key":"spgh"
//      },
//      {
//         "type":"click",
//         "name":"线下培训",
//         "key":"xxpx"
//      }]
// },
// {
//      "name":"领域发道",
//     "sub_button":[
//      {
//         "type":"click",
//         "name":"领域商城",
//         "key":"lysc"
//      },
//      {
//         "type":"click",
//         "name":"了解领域",
//         "key":"lzly"
//      },
//      {
//         "type":"click",
//         "name":"商务合作",
//         "key":"swhz"
//      },
//      {
//         "type":"click",
//         "name":"联系我们",
//         "key":"lxwm"
//      }]
//
// },
//  {
//     "name":"我",
//     "sub_button":[
//       {
//          "type":"click",
//          "name":"个人中心",
//          "key":"grzx"
//      },
//      {
//         "type":"click",
//         "name":"我的订单",
//         "key":"wddd"
//      },
//      {
//         "type":"click",
//         "name":"我的购物车",
//         "key":"wdgwc"
//      },
//      {
//          "type":"click",
//          "name":"我的优惠券",
//          "key":"wdyhq"
//      },
//      {
//         "type":"click",
//         "name":"注册领域会员",
//         "key":"zclyhy"
//      }]
//  }
//
// ]
//  }';


        $data = '{
   "button":[
{
      "name":"原创",
     "sub_button":[
      {
         "type":"click",
         "name":"正在直播",
         "key":"zzzb"
      },
      {
         "type":"click",
         "name":"街拍达人",
         "key":"jpdr"
      },
      {
         "type":"click",
         "name":"极限运动",
         "key":"jxyd"
      },
      {
         "type":"click",
         "name":"健身运动",
         "key":"jsyd"
      },
      {
         "type":"click",
         "name":"幽默小视频",
         "key":"ymxsp"
      }]
 },
 {
      "name":"映山红",
     "sub_button":[
      {
         "type":"view",
         "name":"商城",
         "url":"http://www.yingshanhong.xyz"
      },
      {
         "type":"click",
         "name":"商务合作",
         "key":"swhz"
      },
      {
         "type":"click",
         "name":"了解我们",
         "key":"lj"
      },
      {
         "type":"click",
         "name":"联系我们",
         "key":"lxwm"
      }]

 },
  {
     "name":"我",
     "sub_button":[
       {
          "type":"click",
          "name":"个人中心",
          "key":"grzx"
      },
      {
         "type":"click",
         "name":"我的订单",
         "key":"wddd"
      },
      {
         "type":"click",
         "name":"我的购物车",
         "key":"gwc"
      },
      {
          "type":"click",
          "name":"我的优惠券",
          "key":"yhq"
      },
      {
         "type":"click",
         "name":"注册会员",
         "key":"zchy"
      }]
  }

 ]
  }';

        $MENU_URL = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $ACC_TOKEN;

        $ch = curl_init($MENU_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
        $info = curl_exec($ch);
        $menu = json_decode($info);
        //创建成功返回：{"errcode":0,"errmsg":"ok"}
        print_r($info);

        if ($menu->errcode == "0") {
            echo "菜单创建成功";
        } else {
            echo "菜单创建失败";
        }


    }
}
