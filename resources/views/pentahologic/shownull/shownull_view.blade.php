@php use \App\Http\Controllers\PentahoLogicController; @endphp
@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/shownull')}}">Show Null</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Show Null</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4>Result & Information</h4>
  <pre>
    ID Running : {{ $id_running }}
    Host Name : {{ $datasource_detail['host'] }}
    Database Name : {{ $datasource_detail['db_name'] }}
    User Name : {{ $datasource_detail['db_username'] }}
    Port : {{ $datasource_detail['port'] }}
    Table name : {{ $datasource_detail['tab'] }}
    Column Name : {{ $datasource_detail['col'] }}
  </pre>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>NAMA_PERUSAHAAN</th>
                <th>SELECTED_COLUMN</th>
              </tr>
            </thead>
            @foreach($results as $row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              {{-- <td>{{$row->id}}</td>
              @php $data = PentahoLogicController::jsonReader($row->data, 'data'); @endphp
              @foreach($data as $key => $value)
              <td>{{ $value }}</td>
              @endforeach --}}
              @else
              <tr>
                @endif
                <td>{{$row->NAMA_PERUSAHAAN}}</td>
                <td>{{$row->SELECTED_COLUMN}}</td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
      <a href="{{route('shownull')}}"<button type="button" class="btn btn-block btn-success">Back</button></a><br>
    </div>
  </div>
</div>

<!--/.row-->
@endsection