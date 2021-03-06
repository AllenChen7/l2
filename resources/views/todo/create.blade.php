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
            <form action="{{ route('todo.update', $todo->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
              <input type="hidden" name="_method" value="PUT">
              @else
                <form action="{{ route('todo.store') }}" method="POST" accept-charset="UTF-8">
                  @endif

                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  @include('shared._error')

                  <div class="form-group">
                    <label for="name-field">TODO</label>
                    <input class="form-control" type="text" maxlength="100" name="title" value="{{ old('title', $todo->title ) }}" placeholder="请填写 TODO" required />
                  </div>

                  <div class="form-group">
                    <label for="name-field">请选择分类</label>
                    <select class="form-control" name="cate" required>
                      <option value="" hidden disabled {{ $todo->id ? '' : 'selected' }}>请选择分类</option>
                      @foreach ($todo->cateArr() as $key => $value)
                        <option value="{{ $key }}" {{ $todo->cate == $key ? 'selected' : '' }}>
                          {{ $value }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="name-field">期望开始时间</label>
                    <input class="form-control" type="text" name="plan_start_time" id='plan_start_time' value="{{ old('plan_start_time', $todo->plan_start_time ? date('Y-m-d',  strtotime($todo->plan_start_time)) : '' ) }}" placeholder="期望开始时间" />
                  </div>

                  <div class="form-group">
                    <label for="name-field">期望结束时间</label>
                    <input class="form-control" type="text" name="plan_end_time" id="plan_end_time" value="{{ old('plan_end_time', $todo->plan_end_time ? date('Y-m-d', strtotime($todo->plan_end_time)) : '' ) }}" placeholder="期望结束时间" />
                  </div>

                  <div class="form-group">
                    <label for="name-field">期望去往地点</label>
                    <input class="form-control" type="text" id="keyword" maxlength="100" name="address" value="{{ old('address', $todo->address ) }}" placeholder="请输入关键字：(选定后搜索)" />
                  </div>

                  <div class="form-group">
{{--                    <label for="name-field">请确认地址</label>--}}
                    <input type="hidden" name="longitude" id="hlongitude" value="{{ old('longitude', $todo->longitude ) }}">
                    <input type="hidden" name="latitude" id="hlatitude" value="{{ old('latitude', $todo->latitude ) }}">
                    <input type="hidden" name="adcode" id="adcode" value="{{ old('adcode', $todo->adcode ) }}">
{{--                    <div id="mapContainer" style="height: 200px; position: unset;"></div>--}}
                    <div id="dtCity"></div>
                  </div>

                  <div class="form-group mb-4">
                    <label for="" class="avatar-label">图片</label>
                    <input type="file" name="image" class="form-control-file">
                    @if($todo->image)
                      <br>
                      <img class="thumbnail img-responsive" src="{{ $todo->image }}" width="200" />
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="name-field">备注</label>
                    <textarea name="desc" class="form-control" rows="6" maxlength="500" placeholder="备注">{{ old('desc', $todo->desc ) }}</textarea>
                  </div>

                  <div class="well well-sm">
                    <button type="submit" style="width: 100%" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
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
      zoom: 13,//地图显示的缩放级别
      keyboardEnable: false
    };

    if ('{{$todo->longitude && $todo->latitude}}') {
      var str = '<a class="btn btn-primary" style="width: 100%" href="https://uri.amap.com/marker?position=' + {{$todo->longitude}}
        + ',' + {{$todo->latitude}}
        + '&name=' + '{{$todo->address}}'
        + '" role="button">在地图中打开</a>';
      $('#dtCity').html(str)
      mparams = {
        resizeEnable: true,
        center: [{{$todo->longitude}}, {{$todo->latitude}}],//地图中心点
        zoom: 13,//地图显示的缩放级别
        keyboardEnable: false
      };
    }
    var map = new AMap.Map("mapContainer", mparams);
    AMap.plugin(['AMap.Autocomplete'],function(){
      var autoOptions = {
        city: "北京", //城市，默认全国
        input: "keyword"//使用联想输入的input的id
      };
      autocomplete= new AMap.Autocomplete(autoOptions);
      AMap.event.addListener(autocomplete, "select", function(e){
        console.log(e)
        var longitude = e.poi.location.lng
        var latitude = e.poi.location.lat
        var adcode = e.poi.adcode

        $('#hlongitude').val(longitude)
        $('#hlatitude').val(latitude)
        $('#adcode').val(adcode)

        var str = '<a class="btn btn-primary" style="width: 100%" href="https://uri.amap.com/marker?position=' + longitude
                  + ',' + latitude
                  + '&name=' + e.poi.name
                  + '" role="button">在地图中打开</a>';
        $('#dtCity').html(str)
      });

    });

    // 绑定事件
    var myDate = new Date();
    var today = myDate.getFullYear() + '-' + (myDate.getMonth() + 1) + '-' + myDate.getDate()
    // map.on('click', clickHandler);
    // $("#plan_start_time").datetimePicker({
    //   min: today,
    // });
    // $("#plan_end_time").datetimePicker({
    //   min: today,
    // });
    $("#plan_start_time").calendar({
      minDate: today,
      dateFormat: 'yyyy-mm-dd'
    });
    $("#plan_end_time").calendar({
      minDate: today,
      dateFormat: 'yyyy-mm-dd'
    });
  </script>
@stop
