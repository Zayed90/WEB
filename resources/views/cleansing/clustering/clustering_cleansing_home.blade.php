@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li class="active">Cleansing</li>
    <li><a href="{{url('/cleansing/clustering')}}">Deduplication</a></li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Cleansing Deduplication</h1>
  </div>
</div>
<!--/.row-->

<div class="row">
  <form method="post" action="{{ url('/cleansing/clustering/choose-clustering') }}" enctype="multipart/form-data">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="bs-callout bs-callout-warning">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-xs-12 col-md-6 col-lg-12">
                <div class="form-group">
                  <label>Database Source</label>
                  <select class="form-control" name="tipe_database" id="selectDB" onclick="selectDatabaseMulti()">
                    <option value="mysql">MySQL</option>
                    <option value="postgre">PostgreSQL</option>
                    <option value="CSV">CSV</option>
                  </select>
                  <small class="form-text text-muted" id="small">Settings Database Connection <a href="{{ url('/database') }}">Here</a></small>
                </div>
                </div>
          </div>
        </div>
      </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
      <div class="bs-callout bs-callout-primary">
        <h4>Run Configuration</h4>
        <hr>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>Table Name</label>
              <input id="tableinput1" type="text" class="form-control" name="table">
              <small class="form-text text-muted">Enter table name to be used in this process.</small>
            </div>
            </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label>Column Name</label>
              <input id="tableinput2" type="text" class="form-control" name="column">
              <small class="form-text text-muted">Enter column name to be used in this process.</small>
            </div>
          </div>
              <input type="submit" value="Run" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit">

        </div>
      </form>
    </div>
  </div>
</div>

<div class="bs-callout bs-callout-success">

  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
            <h4>Result</h4>
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>Id</th>
                <th data-field="id" data-sortable="true">Running At</th>
                <th>Result</th>
              </tr>
            </thead>
            @foreach($results as $row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->id_running}}</td>
                <td>{{$row->created_at}}</td>
                <td><a href="{{route('clustering_cleansing_view',['id'=>$row->id_running])}}"<button type="button" class="btn btn-success">See Result</button></a></td>
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
