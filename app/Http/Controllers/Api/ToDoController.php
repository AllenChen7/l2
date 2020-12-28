<?php


namespace App\Http\Controllers\Api;


use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ToDoController extends ApiController
{
    public function index(Request $request, Todo $todo)
    {
        $ids = $request->input('ids', '');
//        $tab  = $request->tab;
        $page = (int)$request->get('page', 1);
        $limit = 10;
        $offset = ($page - 1) < 0 ? 0 : ($page - 1) * $limit;
        $todo = $todo->with('user')
//            ->withCate($tab)
            ->where([
            'status' => 0
        ]);

        if ($ids) {
            $idArr = explode(',', $ids);
            $todo = $todo->whereIn('user_id', $idArr);
        }

        $todo = $todo->orderBy('status')->orderByDesc('id')->limit($limit)->offset($offset)->get()->toArray();

        foreach ($todo as &$value) {
            $value['plan_start_time'] = $value['plan_start_time'] ? \Carbon\Carbon::create($value['plan_start_time'])->diffForHumans() : '';
            $value['plan_end_time'] = $value['plan_end_time'] ? \Carbon\Carbon::create($value['plan_end_time'])->diffForHumans() : '';
            $value['desc'] = Str::limit($value['desc'], 25);
        }

        return $this->jsonSuccessResponse($todo);
    }

    public function add(Request $request, Todo $todo)
    {
        Log::info('res', [
            'res' => $request->all()
        ]);
        $data = $request->all();
        $todo->fill($data);
        $todo->user_id = Auth::id();

        $res = $todo->save();

        if ($res) {
            return $this->jsonSuccessResponse();
        }

        return $this->jsonErrorResponse();
    }

    public function getInfo(Request $request)
    {
        $id = $request->get('id');

        if (!$id) {
            return $this->jsonErrorResponse('数据不存在');
        }

        $data = Todo::where([
            'id' => $id
        ])->with('user')->first();

        if ($data) {
            $nowId = Auth::id();
            $doneFlag = 0;

            if ($nowId == $data['user_id'] && !$data['status']) {
                $doneFlag = 1;
            }

            $data['doneFlag'] = $doneFlag;
            $data['cate'] = $data['cate'] == 1 ? '计划' : '日常';
            return $this->jsonSuccessResponse($data);
        }

        return $this->jsonErrorResponse('数据不存在');
    }

    public function done(Request $request)
    {
        $todo = Todo::find($request->post('id'));

        if ($todo) {
            $todo->status = true;
            $todo->endTime = time();

            if ($todo->save()) {
                return $this->jsonSuccessResponse();
            }
        }

        return $this->jsonErrorResponse();
    }
}
