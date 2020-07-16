@extends('template')
@section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
      <li class="active">Multi Proccessing</li>
    </ol>
  </div><!--/.row-->
  
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Multi Proccess Settings</h1>
    </div>
  </div><!--/.row-->

  <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-12">
        <div class="bs-callout bs-callout-primary">
          <form method="post" action="{{ url('/multiproccess/excute') }}">
                <div class="row">
                        <div  class="col-xs-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                  <label for="exampleInputEmail1">First Step</label>
                                  <select class="form-control" name="first_step">
                                        <option value="Clustering">Clustering</option>
                                        
                                      </select>
                                    </div>
                                </div>
                
                <div class="col-xs-12 col-md-6 col-lg-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Second Step</label>
                  <select class="form-control" name="second_step">
                        <option value="Value Distribution">Value Distribution</option>
                      </select>
                    </div></div></div>
                 </div>
    
    
  
      
          {{ csrf_field() }}
          <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-12">
                <div class="form-group">
                    <label>Database Source</label>
                    <select class="form-control" name="tipe_database">
                      <option value="mysql">MySQL</option>
                      <option value="postgre">PostgreSQL</option>
                    </select>
                    <small class="form-text text-muted">Settings Database Connection <a href="{{ url('/database') }}">Here</a></small>
                  
                  </div>
              </div>    
        </div>
        <div class="bs-callout bs-callout-primary">
          <h4>Run Configuration</h4>
          <hr>
          <div class="row">
          <div class="col-xs-12 col-md-6 col-lg-6">
          <div class="form-group">
            <label for="exampleInputEmail1">Table Name</label>
            <input type="text" class="form-control" name="table">
            <small class="form-text text-muted">Enter table name to be used in this process.</small>
          </div>
          </div>
          <div class="col-xs-12 col-md-6 col-lg-6">
          <div class="form-group">
            <label for="exampleInputEmail1">Column Name</label>
            <input type="text" class="form-control" name="column">
            <small class="form-text text-muted">Enter column name to be used in this process.</small>
          </div></div></div>
          <input type="submit" value="Run" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit">
        </div>
      </div>
    </form>
  </div>

  <div class="bs-callout bs-callout-success">
    <h4> Result</h4>
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
                  <td>{{$row->id}}</td>
                  <td>{{$row->created_at}}</td>
                  <td><a href="{{route('multiproccessView',['id'=>$row->id])}}"<button type="button" class="btn btn-success">See Result</button></a></td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection