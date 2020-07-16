@extends('templateManager')
@section('content')
<div class="row">
  <ol class="breadcrumb">
    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a> {{ Auth::user()->username }}</li>
    <li class="active">Dashboard</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Dashboard Manager</h1>
  </div>
</div><!--/.row-->

<div class="row">
  <div class="col-xs-12 col-md-6 col-lg-4">
    <div class="panel panel-blue panel-widget ">
      <div class="row no-padding">
        <div class="col-sm-3 col-lg-5 widget-left">
          <svg class="glyph stroked monitor"><use xlink:href="#stroked-monitor"/></svg>
        </div>
        <div class="col-sm-9 col-lg-7 widget-right">
          <div class="large">{{$clusteringFalse_M}}</div>
          <div class="text-muted">Rows Status FALSE</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-md-6 col-lg-4">
    <div class="panel panel-teal panel-widget">
      <div class="row no-padding">
        <div class="col-sm-3 col-lg-5 widget-left">
          <svg class="glyph stroked monitor"><use xlink:href="#stroked-monitor"/></svg>
        </div>
        <div class="col-sm-9 col-lg-7 widget-right">
          <div class="large">{{$clusteringTrue_M}}</div>
          <div class="text-muted">Rows Status TRUE</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-md-6 col-lg-4">
    <div class="panel panel-orange panel-widget">
      <div class="row no-padding">
        <div class="col-sm-3 col-lg-5 widget-left">
          <svg class="glyph stroked monitor"><use xlink:href="#stroked-monitor"/></svg>
        </div>
        <div class="col-sm-9 col-lg-7 widget-right">
          <div class="large">{{$null_M}}</div>
          <div class="text-muted">Null / Blank rows</div>
        </div>
      </div>
    </div>
  </div>

</div><!--/.row-->
@endsection
