@extends('layouts.app')

@section('title', 'TODO 列表')

@section('content')

  <div class="row mb-5">
    <div class="col-lg-9 col-md-9 topic-list">
      <div class="card ">
        <div class="card-header bg-transparent">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('todo.create') }}">
                添加 TODO
              </a>
            </li>
          </ul>
        </div>

        <div class="card-body">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}" href="{{ Request::url() }}?tab=">
                will
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'always')) }}" href="{{ Request::url() }}?tab=always">
                always
              </a>
            </li>
          </ul>
        </div>

        <div class="card-body">
          {{-- 话题列表 --}}
          @include('todo._todo_list', ['topics' => $todo])
          {{-- 分页 --}}
          <div class="mt-5">
            {!! $todo->appends(Request::except('page'))->render() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
