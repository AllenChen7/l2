<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

class UploadController extends ApiController
{
    public function image(Request $request)
    {
        dd($request->all());
    }
}
