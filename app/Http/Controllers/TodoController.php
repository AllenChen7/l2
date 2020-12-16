<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);
    }

    public function index(Todo $todo, Request $request)
    {
        $ids = $request->input('ids', '');
        $user = \auth()->user();
        $todo = $todo->with('user')->withCate($request->tab)->where([
            'status' => 0
        ]);

        if ($ids) {
            $idArr = explode(',', $ids);
            $todo = $todo->whereIn('user_id', $idArr);
        }

        $todo = $todo->orderBy('status')->orderByDesc('id')->paginate(20);
        $userData = User::select(['id as value', 'name as title'])->orderByDesc('id')->get()->toArray();
        $usernames = $request->input('usernames', '');
        return view('todo.index', compact('todo', 'user', 'ids', 'usernames', 'userData'));
    }

    public function store(TodoRequest $request, Todo $todo, ImageUploadHandler $uploader)
    {
        $data = $request->all();

        if ($request->image) {
            $result = $uploader->save($request->image, 'todos', 'todo', 416);
            if ($result) {
                $data['image'] = $result['path'];
            }
        }
        $todo->fill($data);
        $todo->user_id = Auth::id();
        $todo->save();

        return redirect()->to('todo')->with('success', '成功添加 TODO！');
    }

    public function create(Todo $todo)
    {
        return view('todo.create', compact('todo'));
    }

    public function edit(Todo $todo)
    {
        $this->authorize('update', $todo);
        return view('todo.create', compact('todo'));
    }

    public function update(TodoRequest $request, Todo $todo, ImageUploadHandler $uploader)
    {
        $this->authorize('update', $todo);
        $data = $request->all();

        if ($request->image) {
            $result = $uploader->save($request->image, 'todos', 'todo', 416);
            if ($result) {
                $data['image'] = $result['path'];
            }
        }
        $todo->update($data);

        return redirect()->to('todo')->with('success', 'TODO 修改成功！');
    }

    public function done(Request $request, Todo $todo)
    {
        $todo = Todo::find($request->post('id'));

        if ($todo) {
            $todo->status = true;
            $todo->endTime = time();

            if ($todo->save()) {
                return response()->json([
                    'status' => 1,
                    'msg' => '已完成'
                ]);
            }
        }

        return response()->json([
            'status' => 0,
            'msg' => '处理失败，请重试'
        ]);
    }

    public function show(Todo $todo)
    {
        return view('todo.show', compact('todo'));
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('destroy', $todo);
        $todo->delete();

        return redirect()->to('todo')->with('success', '成功删除！');
    }
}
