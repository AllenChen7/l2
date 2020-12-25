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
        $page = (int)$request->get('page', 1);
        $limit = 10;
        $offset = ($page - 1) < 0 ? 0 : ($page - 1) * $limit;
        $todo = $todo->with('user')->withCate($tab)->where([
            'status' => 0
        ]);

        if ($ids) {
            $idArr = explode(',', $ids);
            $todo = $todo->whereIn('user_id', $idArr);
        }

        $todo = $todo->orderBy('status')->orderByDesc('id')->limit($limit)->offset($offset)->get()->toArray();

        foreach ($todo as &$value) {
            $value['plan_start_time'] = \Carbon\Carbon::create($value['plan_start_time'])->diffForHumans();
            $value['plan_end_time'] = \Carbon\Carbon::create($value['plan_end_time'])->diffForHumans();
        }

        return $this->jsonSuccessResponse(['data' => $todo]);
    }
}
