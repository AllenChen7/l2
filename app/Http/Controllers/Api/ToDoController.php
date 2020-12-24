<?php


namespace App\Http\Controllers\Api;


use App\Models\Todo;
use Illuminate\Http\Request;

class ToDoController extends ApiController
{
    public function index(Request $request, Todo $todo)
    {
        $ids = $request->input('ids', '');
        $tab  = $request->tab;
        $todo = $todo->with('user')->withCate($tab)->where([
            'status' => 0
        ]);

        if ($ids) {
            $idArr = explode(',', $ids);
            $todo = $todo->whereIn('user_id', $idArr);
        }

        $todo = $todo->orderBy('status')->orderByDesc('id')->paginate(20);

        return $this->jsonSuccessResponse($todo);
    }
}
