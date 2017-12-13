<?php

namespace App\Http\Proxy;


use Illuminate\Support\Facades\Auth;

class TokenProxy
{
    protected $http;


    public function __construct(\GuzzleHttp\Client $http)
    {
        $this->http = $http;
    }

    public function login($email, $password)
    {
        if (auth()->attempt(['email' => $email, 'password' => $password, 'is_active' => 1])) {
            return $this->proxy('password', [
                'username' => $email,
                'password' => $password,
                'scope' => '',
            ]);
        }
        return response()->json([
            'status' => 'false',
            'message' => 'Credentials not match',
        ],421);
    }

    public function refresh(){
        $refreshToken=request()->cookie('refreshToken');
        return $this->proxy('refreshToken',[
            'refresh_token'=>$refreshToken
        ]);
    }

    public function logout()
    {
        $user = auth()->guard('api')->user();
        //注意 这里解决 在登陆超时的情况 是拿不到 $user的
        if(is_null($user)){
            app('cookie')->queue(app('cookie')->forget('refreshToken'));
            return response()->json([
                'message'=>'logout!'
            ],204);

        }
        $accessToken = $user->token();
        //获得accessToken后 标记数据表 数据不可以状态
        app('db')->table('oauth_refresh_tokens')
            ->where('access_token_id',$accessToken->id)
            ->update([
                'revoked'=> true,
            ]);
        //删除refreshToken
        app('cookie')->queue(app('cookie')->forget('refreshToken'));


        $accessToken->revoke();

        return response()->json([
            'message'=>'logout!'
        ],204);


    }

    public function proxy($grantType, array $data = [])
    {
        $data = array_merge($data, [
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'grant_type' => $grantType,
        ]);

        //注意这里的地址
        $response = $this->http->post('http://www.yingshanhong.xyz/oauth/token', [
            'form_params' => $data
        ]);

        $token = json_decode((string)$response->getBody(), true);
        return response()->json([
            'token' => $token['access_token'],
            'auth_id' => md5($token['refresh_token']),
            'expires_in' => $token['expires_in']
        ])->cookie('refreshToken', $token['refresh_token'], 14400, null, null, false, true);

    }


}