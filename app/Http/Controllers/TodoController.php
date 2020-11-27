<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $topics = [];
        return view('todo.index', compact('topics'));
    }
}
