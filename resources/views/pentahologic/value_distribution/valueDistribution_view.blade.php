@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/valueDistribution')}}">Value Distribution</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Value Distribution</h1>
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

  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>Value</th>
                <th>Total</th>
              </tr>
            </thead>
            @foreach($results as $row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->column_value}}</td>
                <td>{{$row->column_value_distribution}}</td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
        <a href="{{route('valueDistribution')}}"<button type="button" class="btn btn-success btn-block">Back</button></a>
      </div>
    </div>
  </div>

  <!--/.row-->
  @endsection
