<?php

namespace App\Http\Controllers\Api;

use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WxController extends ApiController
{
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
}
