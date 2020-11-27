@extends('layouts.app')

@section('content')

  <div class="container" style="padding-right:unset; padding-left:unset;">
    <div class="col-md-12">
      <div class="card ">

        <div class="card-body">
          <h2 class="">
            <i class="far fa-edit"></i>
            @if($todo->id)
              编辑 TODO
            @else
              新建 TODO
            @endif
          </h2>

          <hr>

          @if($todo->id)
            <form action="{{ route('topics.update', $todo->id) }}" method="POST" accept-charset="UTF-8">
              <input type="hidden" name="_method" value="PUT">
              @else
                <form action="{{ route('todo.store') }}" method="POST" accept-charset="UTF-8">
                  @endif

                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  @include('shared._error')

                  <div class="form-group">
                    <input class="form-control" type="text" name="title" value="{{ old('title', $todo->title ) }}" placeholder="请填写 TODO" required />
                  </div>

                  <div class="form-group">
                    <textarea name="desc" class="form-control" rows="6" placeholder="请填入至少三个字符的备注。" required>{{ old('desc', $todo->desc ) }}</textarea>
                  </div>

                  <div class="well well-sm">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
                  </div>
                </form>
        </div>
      </div>
    </div>
  </div>

@endsection
