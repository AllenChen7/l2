<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index(Todo $todo)
    {
        $todo = $todo->with('user')->orderByDesc('id')->paginate(20);
        return view('todo.index', compact('todo'));
    }

    public function store(TodoRequest $request, Todo $todo)
    {
        $todo->fill($request->all());
        $todo->user_id = Auth::id();
        $todo->save();

        return redirect()->to($todo->link())->with('success', '成功添加 TODO！');
    }

    public function create(Todo $todo)
    {
        return view('todo.create', compact('todo'));
    }
}
