@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/pattern')}}">Pattern</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->
<a class="" href="{{url('cleansing/null/resultnull')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-left:29px;margin-top:20px;margin-bottom:20px;"type="button"class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back</button></a> &nbsp&nbsp

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Cleansing Null Result</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4 style="margin-left:20px;">Result & Information</h4>

  <br><br>
  <button formaction="#" class="bt2 caw">  ID Running : <strong>{{ $id_running }}</strong></button>
  <button formaction="#" class="bt2 caw">  Host Name  : <strong> {{ $datasource_detail['host'] }}</strong></button>
  <button formaction="#" class="bt2 caw">  Database Name : <strong>{{ $datasource_detail['db_name'] }}</strong></button>
  <button formaction="#" class="bt2 caw">  User Name : <strong> {{ $datasource_detail['db_username']}}</strong></button>
  <button formaction="#" class="bt2 caw">  Port : <strong> {{ $datasource_detail['port']}}</strong></button>
  <button formaction="#" class="bt2 caw">  Table name : <strong> {{ $datasource_detail['tab']}}</strong></button>
  <button formaction="#" class="bt2 caw">  Column Name : <strong> {{ $datasource_detail['col'] }}</strong></button>
  <hr>


  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>Old Data Column</th>
                <th>Refrence</th>
                <th>New Data Column</th>
              </tr>
            </thead>
            @foreach($results as $row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->nama_merk_lama}}</td>
                <td>{{$row->nama_produk}}</td>
                <td>{{$row->nama_merk_baru}}</td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
        <a href="{{url('/cleansing/null')}}"<button type="button" class="btn btn-success btn-block">Back</button></a>
      </div>
    </div>
  </div>

  <!--/.row-->
  @endsection
<style>
.caw {
  color: black;
  border-bottom: 5px double  #30A5FF; 
  margin:6px;
  margin-left:10px;
}
</style>