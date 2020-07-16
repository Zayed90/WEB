@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/dataDeduplication')}}">Data Deduplication</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Data Deduplication</h1>
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
    First Table name : {{ $datasource_detail['tab1'] }}
    Second Table name : {{ $datasource_detail['tab2'] }}
    First Column Name(First Table) : {{ $datasource_detail['col1a'] }}
    Second Column Name(First Table) : {{ $datasource_detail['col1b'] }}
    First Column Name(Second Table) : {{ $datasource_detail['col2a'] }}
    Second Column Name(Second Table) : {{ $datasource_detail['col2b'] }}

    > Measured Value Information
    EMPTY : There is no duplicate
    0 : There is a duplicate or same data
    1 : There is a probability of duplicate
  </pre>

  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>Id</th>
                <th>Column Value</th>
                <th>Matched Value</th>
                <th>Measured Value</th>
              </tr>
            </thead>
            @foreach($results as $row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->id}}</td>
                <td>{{$row->column_name_1}}</td>
                <td>{{$row->match_value}}</td>
                <td>{{$row->measure_value}}</td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
        <a href="{{route('dataDeduplication')}}"<button type="button" class="btn btn-block btn-success">Back</button></a>
      </div>
    </div>
  </div>

  <!--/.row-->
  @endsection
