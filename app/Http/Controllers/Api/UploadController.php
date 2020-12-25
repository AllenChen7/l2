<?php


namespace App\Http\Controllers\Api;


use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;

class UploadController extends ApiController
{
    public function image(Request $request, ImageUploadHandler $uploader)
    {
        $path = '';

        if ($request->file) {
            $result = $uploader->save($request->file, 'todos', 'todo', 416);

            if ($result) {
                $path = $result['path'];
            }
        }

        if ($path) {
            return $this->jsonSuccessResponse([
                'path' => $path
            ]);
        } else {
            return $this->jsonErrorResponse();
        }
    }
}
