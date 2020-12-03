<?php

namespace App\Http\Requests;

class TodoRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
                // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'       => 'required|min:2',
                    'desc'        => 'required|min:3',
                    'plan_start_time' => 'required',
                    'plan_end_time' => 'required|after:plan_start_time',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
                {
                    return [];
                }
        }
    }

    public function messages()
    {
        return [
            'title.min' => 'TODO 必须至少两个字符',
            'desc.min' => '内容备注必须至少三个字符',
        ];
    }

    /**
     * 获取验证错误的自定义属性
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'plan_start_time' => '期望开始时间',
            'plan_end_time' => '期望结束时间',
        ];
    }
}
