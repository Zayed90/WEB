@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/pattern')}}">Pattern</a></li>
    <li class="active">Run</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Run Pattern</h1>
  </div>
</div><!--/.row-->

<div class="row">
  @if (session()->has('success'))
  <div class="alert alert-success" role="alert">{{ session()->get('success')}}</div>
  @endif
  @if (session()->has('error'))
  <div class="alert alert-error" role="alert">{{ session()->get('error')}}</div>
  @endif
  <form method="post" action="{{ url('/pentaho/pattern/process') }}" enctype="multipart/form-data">
    <div class="col-xs-12 col-md-6 col-lg-12">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-xs-12 col-md-6 col-lg-12">
            <div class="form-group">
              <label>Database Source</label>
              <select class="form-control" name="tipe_database" id="selectDB" onclick="selectDatabase()">
                <option value="mysql">MySQL</option>
                <option value="postgre">PostgreSQL</option>
                <option value="CSV">CSV</option>
              </select>
              <small class="form-text text-muted" id="small">Settings Database Connection <a href="{{ url('/database') }}">Here</a></small>
            
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
          <input id="tableinput" type="text" class="form-control" name="table">
          <small class="form-text text-muted">Enter table name to be used in this process.</small>
        </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-6">
        <div class="form-group">
          <label for="exampleInputEmail1">Column Name</label>
          <input type="text" class="form-control" name="column">
          <small class="form-text text-muted">Enter column name to be used in this process.</small>
        </div></div>
        <div class="col-xs-12 col-md-6 col-lg-12">
          <div class="form-group">
            <label for="exampleInputEmail1">Special Condition</label>
            <select class="form-control" name="condition">
              <option value="">None</option>
              <option value="id_app = 1">Ereg</option>
              <option value="id_app = 2">Asrot</option>
              <option value="id_app = 3">Etrack DN</option>
              <option value="id_app = 4">Etrack LN</option>
            </select>
            <small class="form-text text-muted">Select app condition command or you can leave it to "none" if no condition need.</small>
          </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-6">
            {{-- <div class="form-group">
              <label for="exampleInputEmail1">Label Name</label>
              <input type="text" class="form-control" name="label">
              <small class="form-text text-muted">Enter label name to describe label your proccess.</small>
            </div> --}}
            </div>
      
      </div>
        <input type="submit" value="Run" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit">
      </div>
    </div>
  </form>
</div>

<div class="bs-callout bs-callout-success">
  <h4><center>Pattern Result Here</center></h4>
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
                <td><a href="{{route('patternView',['id'=>$row->id_running])}}"<button type="button" class="btn btn-success">See Result</button></a></td>
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
