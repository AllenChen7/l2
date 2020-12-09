<?php

function route_class()
{
    return str_replace('.', '-', \Illuminate\Support\Facades\Route::currentRouteName());
}

function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return \Illuminate\Support\Str::limit($excerpt, $length);
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);

    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';

    // 使用站点 URL 拼接全量 URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);

    // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
    $class_name = class_basename($full_class_name);

    // 蛇形命名，例如：传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snake_case_name = Str::snake($class_name);

    // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
    return Str::plural($snake_case_name);
}

function transWeek($value = '')
{
    if (!$value) {
        $value = date('Y-m-d');
    }

    $str = \Carbon\Carbon::create($value)->dayOfWeek;

    $weekArr = [
        0 => '星期日',
        1 => '星期一',
        2 => '星期二',
        3 => '星期三',
        4 => '星期四',
        5 => '星期五',
        6 => '星期六',
    ];

    return $weekArr[$str];
}

function getWeather($address = '', $day = '')
{
    $str = '';
    if (!$day) {
        $day = \Carbon\Carbon::now();
    } else {
        $day = \Carbon\Carbon::create($day);
    }

    $diff = $day->diffInDays($day);

    if ($diff > 7) {
        return $str;
    }

    \Illuminate\Support\Facades\Log::info('address', [
        'address' => $address,
        'day' => $day,
        'diff' => $diff
    ]);

    if (!$address) {
        $req = new \Illuminate\Http\Request();
        $ip = $req->getClientIp();
        $address = \Zhuzhichao\IpLocationZh\Ip::find($req->getClientIp());
        \Illuminate\Support\Facades\Log::info('ip', [
            'ip' => $ip,
            'address' => $address
        ]);
    }

    if (!$address) {
        return $str;
    }

    $weather = app('weather')->getLiveWeather($address);

    \Illuminate\Support\Facades\Log::info('weather', [
        'weather' => $weather
    ]);
}
