<?php

namespace App\Http\Controllers\Api;

use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WxController extends ApiController
{
    /**
     * 这里请求成功后应该直接生成 token 的，标识已登录成功
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function wxMiniLogin(Request $request)
    {
        $config = config('wxmini');
        $app = Factory::miniProgram($config);
        $code = $request->get('code');

        $user = $app->auth->session($code);
        Log::info('user code info', [
            'code' => $code,
            'res' => $user
        ]);

        if (isset($user['errcode'])) {
            return $this->jsonErrorResponse($user['errmsg']);
        }

        return $this->jsonSuccessResponse($user);
    }

    public function wxMiniUserInfo(Request $request)
    {
        $params = $request->post();
        Log::info('user info', [
            'user info' => $params
        ]);

        return $this->jsonSuccessResponse([
            'p' => $params
        ]);
    }
}
