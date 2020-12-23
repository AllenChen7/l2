<?php


namespace App\Http\Controllers\Api;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TestController extends ApiController
{
    public function yy()
    {
        $uri = 'https://v1.hitokoto.cn';
        $cacheStr = 'yy_str';
        $str = Cache::get($cacheStr);

        if ($str) {

            return $this->jsonSuccessResponse([
                'yy' => $str
            ]);
        } else {
            $response = Http::get($uri);

            if ($response->ok()) {
                $str = isset($response->json()['hitokoto']) ? $response->json()['hitokoto'] : '';
                Cache::put($cacheStr, $str, 20);

                return $this->jsonSuccessResponse([
                    'yy' => $str
                ]);
            } else {
                return $this->jsonSuccessResponse([
                    'yy' => '好好学习，天天向上'
                ]);
            }
        }
    }
}
