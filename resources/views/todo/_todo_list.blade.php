@if (count($todo))
  <ul class="list-unstyled">
    @foreach ($todo as $topic)
      <li class="media">
        <div class="media-left">
          <a href="{{ route('users.show', [$topic->user_id]) }}">
            <img class="media-object img-thumbnail mr-3" style="width: 52px; height: 52px;" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}">
          </a>
        </div>

        <div class="media-body">

          <div class="media-heading mt-0 mb-1">
            <a href="{{ route('todo.show', $topic->id) }}" title="{{ $topic->title }}">
              {{ \Illuminate\Support\Str::of($topic->title)->limit(20) }}
            </a>
            @can('update', $topic)
              <a class="float-right" href="#" onclick="checkDone({{ $topic->id  }})">
                <input type="checkbox" @if ($topic->status) checked disabled @endif  id="checkbox_{{ $topic->id  }}">
              </a>
            @endcan
          </div>

          <div class="media-heading mt-0 mb-1">
            <small class="media-body meta text-secondary">
              <span> 期望开始时间： </span>{{ $topic->plan_start_time ? \Carbon\Carbon::create($topic->plan_start_time)->diffForHumans() : '长期'}}
            </small>
          </div>

          <small class="media-body meta text-secondary">
            <span> • </span>
            <a class="text-secondary" href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user->name }}">
              <i class="far fa-user"></i>
              {{ \Illuminate\Support\Str::of($topic->user->name)->limit(10) }}
            </a>
            <span> • </span>
            <i class="far fa-clock"></i>
            <span class="timeago" title="创建于：{{ $topic->created_at }}">{{ $topic->created_at->diffForHumans() }}</span>
          </small>

        </div>
      </li>

      @if ( ! $loop->last)
        <hr>
      @endif

    @endforeach
  </ul>

@else
  <div class="empty-block">暂无数据 ~_~ </div>
@endif

@section('styles')
  <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.3/style/weui.min.css">
  <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.1/css/jquery-weui.min.css">
@stop

@section('scripts')
  <script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
  <script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js"></script>
  <script>
    $("#userSelect").select({
      title: "选择职业",
      multi: true,
      items: [
        {
          title: "画画",
          value: 1
        },
        {
          title: "打球",
          value: 2
        },
        {
          title: "唱歌",
          value: 3
        },
        {
          title: "游泳",
          value: 4
        },
      ],
      onChange: function () {
        console.log(111)
      },
      onClose: function () {
        console.log(222)
        var usernames = $('#userSelect').val()
        console.log(usernames, 'usernames')
        var ids = $('#userSelect').data('values')
        window.location.href = '/todo?ids=' + ids + '&usernames=' + usernames;
      }
    });
  </script>
@stop

<script>
  function checkDone(id) {
    $.confirm("确认已完成当前 TODO", function() {
      //点击确认后的回调函数
      var data = {
        id: id,
        _token: "{{ csrf_token() }}"
      }
      $.ajax({
        type: "POST",
        url: "{{ route('todo.done')  }}",
        data: data,
        success: function(data){
          console.log(data)
          if (data.status) {
            $.toast(data.msg)
            $('#checkbox_' + id).attr('disabled', 'disabled')
          } else {
            $('#checkbox_' + id).removeAttr('checked')
            $.toast(data.msg)
          }
        }
      });
    }, function() {
      //点击取消后的回调函数
      $('#checkbox_' + id).removeAttr('checked')
      $.toast("已取消", "cancel");
    });
  }
</script>
