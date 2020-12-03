@extends('layouts.app')

@section('content')
  <style>
    .footer {
      position:unset;
    }
  </style>

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
            <form action="{{ route('todo.update', $todo->id) }}" method="POST" accept-charset="UTF-8">
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
                    <input class="form-control" type="text" name="plan_start_time" id='plan_start_time' value="{{ old('title', $todo->plan_start_time ) }}" placeholder="" required />
                  </div>

                  <div class="form-group">
                    <label for="name-field">期望结束时间</label>
                    <input class="form-control" type="text" name="plan_end_time" id="plan_end_time" value="{{ old('title', $todo->plan_end_time ) }}" placeholder="" required />
                  </div>

                  <div class="form-group">
                    <label for="name-field">期望去往地点</label>
                    <input class="form-control" type="text" id="keyword" name="address" value="{{ old('title', $todo->address ) }}" onfocus='this.value=""' placeholder="请输入关键字：(选定后搜索)" required />
                  </div>

                  <div class="form-group">
{{--                    <label for="name-field">请确认地址</label>--}}
                    <input type="hidden" name="longitude" id="hlongitude" value="{{ old('title', $todo->longitude ) }}">
                    <input type="hidden" name="latitude" id="hlatitude" value="{{ old('title', $todo->latitude ) }}">
                    <div id="mapContainer" style="height: 200px; position: unset;"></div>
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
  <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.3/style/weui.min.css">
  <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.1/css/jquery-weui.min.css">
@stop

@section('scripts')
  <script type="text/javascript"
          src="https://webapi.amap.com/maps?v=1.4.15&key={{env('GD_KEY')}}"></script>
  <script type="text/javascript" src="https://webapi.amap.com/demos/js/liteToolbar.js"></script>
  <script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
  <script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js"></script>

  <script>
    var windowsArr = [];
    var marker = [];
    var mparams = {
      resizeEnable: true,
      center: [116.397428, 39.90923],//地图中心点
      zoom: 13,//地图显示的缩放级别
      keyboardEnable: false
    };

    if ('{{$todo->longitude && $todo->latitude}}') {
      mparams = {
        resizeEnable: true,
        center: [{{$todo->longitude}}, {{$todo->latitude}}],//地图中心点
        zoom: 13,//地图显示的缩放级别
        keyboardEnable: false
      };
    }
    var map = new AMap.Map("mapContainer", mparams);
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
        // placeSearch.setCity(e.poi.adcode);
        placeSearch.search(e.poi.name)
        console.log(e.poi.location)
        var longitude = e.poi.location.lng
        var latitude = e.poi.location.lat

        $('#hlongitude').val(longitude)
        $('#hlatitude').val(latitude)
      });
    });

    var clickHandler = function(e) {
      console.log(e)
      // alert('您在[ '+e.lnglat.getLng()+','+e.lnglat.getLat()+' ]的位置点击了地图！');
    };

    // 绑定事件
    // map.on('click', clickHandler);
    $("#plan_start_time").datetimePicker();
    $("#plan_end_time").datetimePicker();
  </script>
@stop
