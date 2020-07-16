@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/cardinalities/pattern')}}">cardinalities</a></li>
    <li class="active">Run</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Run Cardinalities</h1>
  </div>
</div><!--/.row-->

<div class="row">
  @if (session()->has('success'))
  <div class="alert alert-success" role="alert">{{ session()->get('success')}}</div>
  @endif
  @if (session()->has('error'))
  <div class="alert alert-error" role="alert">{{ session()->get('error')}}</div>
  @endif
  <form method="post" action="{{ url('/pentaho/cardinalities/process') }}">
    <div class="col-xs-12 col-md-6 col-lg-6">
      <div class="bs-callout bs-callout-warning">
        <h4>Source Data Configuration</h4><br>
        <ul>
          {{ csrf_field() }}
          <div class="form-group">
            <small class="form-text text-muted">Host Name.</small>
            <input type="text" class="form-control" name="host">
          </div>
          <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-6">
              <div class="form-group">
                <small class="form-text text-muted">Port Number.</small>
                <input type="text" class="form-control" name="port">
              </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6">
              <div class="form-group">
                <small class="form-text text-muted">Database Name.</small>
                <input type="text" class="form-control" name="db_name">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-6">
              <div class="form-group">
                <small class="form-text text-muted">Username.</small>
                <input type="text" class="form-control" name="db_username">
              </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6">
              <div class="form-group">
                <small class="form-text text-muted">Password.</small>
                <input type="password" class="form-control" name="db_password">
              </div>
            </div>
          </div>
        </ul>
      </div>
    </div>

    <div class="col-xs-12 col-md-6 col-lg-6">
      <div class="bs-callout bs-callout-primary">
        <h4>Run Configuration</h4>
        <hr>
        {{ csrf_field() }}
        <div class="form-group">
          <label for="exampleInputEmail1">Table Name</label>
          <input type="text" class="form-control" name="table">
          <small class="form-text text-muted">Enter table name to be used in this process.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Column Name</label>
          <input type="text" class="form-control" name="column">
          <small class="form-text text-muted">Enter column name to be used in this process.</small>
        </div>
        <input type="submit" value="Run" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit">
      </form>
    </div>
  </div>
</div>

<div class="bs-callout bs-callout-success">
  <h4>Cardinalities Result</h4>
  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>id</th>
                <th data-field="id" data-sortable="true">Running At</th>
                <th>Total Null</th>
                <th>Total Data</th>
                <th>Minimum Value</th>
                <th>Maximum Value</th>
                <th>Median</th>
                <th>Mean</th>
                <th>Column Distinct Value</th>
                <th>Running Detail</th>
              </tr>
            </thead>
            @foreach($results as $row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->id}}</td>
                <td>{{$row->created_at}}</td>
                <td>{{$row->total_null}}</td>
                <td>{{$row->total_data}}</td>
                <td>{{$row->minimum_value}}</td>
                <td>{{$row->maximum_value}}</td>
                <td>{{$row->median}}</td>
                <td>{{$row->mean}}</td>
                <td>{{$row->column_distinct_value}}</td>
                <td>{{$row->datasource_detail}}</td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--/.row-->
  @endsection
