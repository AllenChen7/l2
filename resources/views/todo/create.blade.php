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
                    <label for="name-field">TODO</label>
                    <input class="form-control" type="text" name="title" value="{{ old('title', $todo->title ) }}" placeholder="请填写 TODO" required />
                  </div>

                  <div class="form-group">
                    <label for="name-field">期望开始时间</label>
                    <input class="form-control" type="text" name="title" value="{{ old('title', $todo->title ) }}" placeholder="" required />
                  </div>

                  <div class="form-group">
                    <label for="name-field">期望结束时间</label>
                    <input class="form-control" type="text" name="title" value="{{ old('title', $todo->title ) }}" placeholder="" required />
                  </div>

                  <div class="form-group">
                    <label for="name-field">期望去往地点</label>
                    <input class="form-control" type="text" id="keyword" name="keyword" value="{{ old('title', $todo->title ) }}" onfocus='this.value=""' placeholder="请输入关键字：(选定后搜索)" required />
                  </div>

                  <div class="form-group">
                    <label for="name-field">请确认地址</label>
                    <div id="mapContainer" style="height: 200px; position: unset"></div>
                  </div>

                  <div class="form-group">
                    <label for="name-field">备注</label>
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

@section('styles')
  <link rel="stylesheet" type="text/css" href="https://cache.amap.com/lbs/static/main.css">
@stop

@section('scripts')
  <script type="text/javascript"
          src="https://webapi.amap.com/maps?v=1.4.15&key={{env('GD_KEY')}}"></script>
  <script type="text/javascript" src="https://webapi.amap.com/demos/js/liteToolbar.js"></script>

  <script>
    var windowsArr = [];
    var marker = [];
    var map = new AMap.Map("mapContainer", {
      resizeEnable: true,
      // center: [116.397428, 39.90923],//地图中心点
      zoom: 13,//地图显示的缩放级别
      keyboardEnable: false
    });
    AMap.plugin(['AMap.Autocomplete','AMap.PlaceSearch'],function(){
      var autoOptions = {
        city: "北京", //城市，默认全国
        input: "keyword"//使用联想输入的input的id
      };
      autocomplete= new AMap.Autocomplete(autoOptions);
      var placeSearch = new AMap.PlaceSearch({
        city:'北京',
        map:map
      })
      AMap.event.addListener(autocomplete, "select", function(e){
        //TODO 针对选中的poi实现自己的功能
        placeSearch.setCity(e.poi.adcode);
        placeSearch.search(e.poi.name)
      });
    });
  </script>
@stop
