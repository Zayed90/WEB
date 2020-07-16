@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/dataCompleteness')}}">Data Completeness</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Data Completeness</h1>
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

    > Type Information
    NOT_COMPLETE : There is some probability that checked value is not typed correctly
    NOT_IN_DICTIONARY : Cannot find the value in Dictionary
  </pre>

  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>Id</th>
                <th>Value</th>
                <th>Matched Dictionary Value</th>
                <th>Type</th>
              </tr>
            </thead>
            @foreach($results as $row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->id}}</td>
                <td>{{$row->value}}</td>
                <td>{{$row->match_value}}</td>
                <td>{{$row->type}}</td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
        <a href="{{route('dataCompleteness')}}"<button type="button" class="btn btn-block btn-success">Back</button></a>
      </div>
    </div>
  </div>

  <!--/.row-->
  @endsection
