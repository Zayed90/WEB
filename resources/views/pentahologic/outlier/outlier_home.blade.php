@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/outlier')}}">Outlier</a></li>
    <li class="active">Run</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Run Outlier</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-primary">
  <h4>Run Configuration</h4>
  <hr>
  <form method="post" action="{{ url('/pentaho/outlier/process') }}">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="exampleInputEmail1">Table Name</label>
      <input type="text" class="form-control" name="table">
      <small class="form-text text-muted">Enter table name to be used in this process.</small>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Column Name 1</label>
      <input type="text" class="form-control" name="column1">
      <small class="form-text text-muted">Enter first column name to be used in this process.</small>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Column Name 2</label>
      <input type="text" class="form-control" name="column2">
      <small class="form-text text-muted">Enter second column name to be used in this process.</small>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Column Name 3</label>
      <input type="text" class="form-control" name="column3">
      <small class="form-text text-muted">Enter third column name to be used in this process.</small>
    </div>
    <input type="submit" value="Run" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit">
  </form>
</div>

<div class="bs-callout bs-callout-success">
  <h4>Outlier Result</h4>
  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
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
                <td><a href="{{route('outlierView',['id'=>$row->id_running])}}"<button type="button" class="btn btn-success">See Result</button></a></td>
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
