@extends('layouts.app')

@section('title', $todo->title)

@section('content')

  <div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
      <div class="card ">
        <div class="card-body">
          <div class="text-center">
            作者：{{ $todo->user->name }}
          </div>
          <hr>
          <div class="media">
            <div align="center">
              <a href="{{ route('users.show', $todo->user->id) }}">
                <img class="thumbnail img-fluid" src="{{ $todo->user->avatar }}" width="300px" height="300px">
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
      <div class="card ">
        <div class="card-body">
          <h1 class="text-center mt-3 mb-3">
            {{ $todo->title }}
          </h1>

          <div class="article-meta text-center text-secondary">
            {{ $todo->created_at->diffForHumans() }}
          </div>

          <div class="topic-body mt-4 mb-4">
            <div class="form-group">
              <label for="name-field">期望开始时间</label>
              <input class="form-control" type="text" readonly name="plan_start_time" id='plan_start_time' value="{{ old('plan_start_time', $todo->plan_start_time ) }}" />
            </div>

            <div class="form-group">
              <label for="name-field">期望结束时间</label>
              <input class="form-control" type="text" readonly name="plan_end_time" id="plan_end_time" value="{{ old('plan_end_time', $todo->plan_end_time ) }}"/>
            </div>

            <div class="form-group">
              <label for="name-field">期望去往地点</label>
              <input class="form-control" type="text" readonly id="keyword" name="address" value="{{ old('address', $todo->address ) }}" />
            </div>

            <div class="form-group mb-4">
              <label for="" class="avatar-label">图片</label>
              @if($todo->image)
                <br>
                <img class="thumbnail img-responsive" src="{{ $todo->image }}" width="200" />
              @endif
            </div>

            <div class="form-group">
              <label for="name-field">备注</label>
              <textarea name="desc" class="form-control" rows="6" readonly>{{ old('desc', $todo->desc ) }}</textarea>
            </div>
          </div>
          @can('update', $todo)
            <div class="operate">
              <hr>
              @can('edit', $todo)
                <a href="{{ route('todo.edit', $todo->id) }}" class="btn btn-primary" role="button" style="width: 40%">
                  <i class="far fa-edit"></i> 编辑
                </a>
              @endcan
              <form action="{{ route('todo.destroy', $todo->id) }}" method="post"
                    style="display: inline-block; width: 40%"
                    onsubmit="return confirm('您确定要删除吗？');">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-warning" style="width: 100%; margin-left: 50px">
                  <i class="far fa-trash-alt"></i> 删除
                </button>
              </form>
            </div>
          @endcan

        </div>
      </div>

    </div>
  </div>
@stop
