<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title', 'desc', 'user_id', 'endTime', 'status', 'address',
        'latitude', 'longitude', 'plan_end_time', 'plan_start_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function link($params = [])
    {
        return route('todo', array_merge([$this->id], $params));
    }

    public function getPlanEndTimeAttribute($value)
    {
        if ($value) {
            $value = date('Y-m-d H:i', strtotime($value));
        }

        return $value;
    }

    public function getPlanStartTimeAttribute($value)
    {
        if ($value) {
            $value = date('Y-m-d H:i', strtotime($value));
        }

        return $value;
    }
}
