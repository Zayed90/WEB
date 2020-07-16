@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/pattern')}}">Pattern</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><strong>View Result After Choose The Pattern</strong></h3>

  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
<a class="" href="{{url('cleansing/pattern/result_choose_pattern')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button"class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back</button></a> &nbsp&nbsp
<a class="" href="{{url('cleansing/pattern/pattern_punctuation')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg"type="button"class="bt1 skip btn-lg active"> Next to Punctuation &nbsp <i class="fa fa-angle-double-right" style="font-size:25px;color:#000000"></i></button></a> &nbsp&nbsp

<br><br>
  <button formaction="#" class="bt2 caw">  ID Running : <strong>{{ $id_running }}</strong></button>
  <button formaction="#" class="bt2 caw">  Host Name  : <strong> {{ $datasource_detail['host'] }}</strong></button>
  <button formaction="#" class="bt2 caw">  Database Name : <strong>{{ $datasource_detail['db_name'] }}</strong></button>
  <button formaction="#" class="bt2 caw">  User Name : <strong> {{ $datasource_detail['db_username']}}</strong></button>
  <button formaction="#" class="bt2 caw">  Port : <strong> {{ $datasource_detail['port']}}</strong></button>
  <button formaction="#" class="bt2 caw">  Table name : <strong> {{ $datasource_detail['tab']}}</strong></button>
  <button formaction="#" class="bt2 caw">  Column Name : <strong> {{ $datasource_detail['col'] }}</strong></button>
  <hr>
  <div class="row">
    <div class="col-lg-12">
        <form method="post" action="{{ url('/cleansing/pattern/manualProcessSub') }}">
          {{ csrf_field() }}
        
      <div class="panel panel-default">     
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>NIE Default</th>
                <th>Pattern Not Cleansed</th>
                <th>Pattern Changed</th>
                <th>Data Cleansed</th>
                <th>Status</th>
              </tr>
            </thead>
            @foreach($results as $i=>$row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->NOMOR_NIE}}</td>
              <td>{{$row->PATTERN_LAMA}}</td>
              <td>{{$row->NOMOR_PATTERN_BARU}}</td>
              <td>
                <p>{{$row->nomor_cleansed}}</p>
                    <input id="p-input{{$i}}" style="display:none;" type="text" value={{$row->nomor_cleansed}}>
                </td>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!--/.row-->
  @endsection
  