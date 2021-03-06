<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Todo extends Model
{
    protected $fillable = ['title', 'desc', 'user_id', 'endTime', 'status', 'address',
        'latitude', 'longitude', 'plan_end_time', 'plan_start_time', 'image', 'cate', 'adcode'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function link($params = [])
    {
        return route('todo', array_merge([$this->id], $params));
    }

    public function getPlanEndTimeStr($value)
    {
        // 获取天气
        $weather = getWeather($this->adcode, $this->plan_end_time);
        if ($value) {
            $carbon = new Carbon();
            $diffDays = $carbon::create($value)->diffForHumans();
            $week = transWeek($value);
            $value = date('Y-m-d', strtotime($value)) . '（' . $diffDays . ')'  .  '（' . $week . '）';
        }

        return $value;
    }

    public function getPlanStartTimeStr($value)
    {
        if ($value) {
            $carbon = new Carbon();
            $diffDays = $carbon::create($value)->diffForHumans();
            $week = transWeek($value);
            $value = date('Y-m-d', strtotime($value)) . '（' . $diffDays . ')'  .  '（' . $week . '）';
        }

        return $value;
    }

//    public function getPlanStartTimeAttribute($value)
//    {
//        if ($value) {
//            $value = date('Y-m-d', strtotime($value));
//        }
//
//        return $value;
//    }
//
//    public function getPlanEndTimeAttribute($value)
//    {
//        if ($value) {
//            $value = date('Y-m-d', strtotime($value));
//        }
//
//        return $value;
//    }

    public function setPlanEndTimeAttribute($value)
    {
        if ($value) {
            $value = $value . ' 23:59:59';
        }

        $this->attributes['plan_end_time'] = $value;
    }

    public function cateArr()
    {
        return [
            1 => '计划',
            2 => '日常'
        ];
    }

    public function scopeWithCate($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'always':
                $query->where([
                    'cate' => 2
                ]);
                break;

            default:
                $query->where([
                    'cate' => 1
                ]);
                break;
        }
    }
}
