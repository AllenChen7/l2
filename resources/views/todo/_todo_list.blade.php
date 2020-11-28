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
            <a href="{{ $topic->link() }}" title="{{ $topic->title }}">
              {{ $topic->title }}
            </a>
            <a class="float-right" href="#" onclick="checkDone({{ $topic->id  }})">
              <input type="checkbox" @if ($topic->status) checked disabled @endif  id="checkbox_{{ $topic->id  }}">
            </a>
          </div>

          <small class="media-body meta text-secondary">


            <span> • </span>
            <a class="text-secondary" href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user->name }}">
              <i class="far fa-user"></i>
              {{ $topic->user->name }}
            </a>
            <span> • </span>
            <i class="far fa-clock"></i>
            <span class="timeago" title="最后活跃于：{{ $topic->updated_at }}">{{ $topic->updated_at->diffForHumans() }}</span>
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

<script>
  function checkDone(id) {
    console.log(id)
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
          alert(data.msg)
          $('#checkbox_' + id).attr('disabled', 'disabled')
        } else {
          $('#checkbox_' + id).removeAttr('checked')
          alert(data.msg)
        }
      }
    });
  }
</script>
