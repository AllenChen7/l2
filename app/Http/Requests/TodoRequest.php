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
}
