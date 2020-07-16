@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('#')}}">Master Data</a></li>
    <li class="active">Data Test</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Master Data</h1>
  </div>
</div><!--/.row-->
<div class="bs-callout bs-callout-warning">
  <h4>Dummy Source Data</h4>
  <br>
  <div class="alert bg-teal" role="alert"><em class="fa fa-lg fa-info-circle">&nbsp;</em> <i>  Default data inside database, intended for testing pentaho logic and you can use your own data or this data to test run the pentaho logic</i></div>
  <hr>
  <div class="row">

    <div class="col-xs-12 col-md-6 col-lg-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          ereg_m_pabrik
        </div>
        <div class="panel-body">
          <p>
            Total Row : {{$rows_eregmpabrik}} <br>
            Total Collumn : {{$cols_eregmpabrik}} <br><hr>
            <a href="{{url('sourceView/ereg_m_pabrik')}}"<button type="button" class="btn btn-primary btn-block">View Data</button></a>
          </p>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-md-6 col-lg-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          ereg_m_trader
        </div>
        <div class="panel-body">
          <p>
            Total Row : {{$rows_eregmtrader}} <br>
            Total Collumn : {{$cols_eregmtrader}} <br><hr>
            <a href="{{url('sourceView/ereg_m_trader')}}"<button type="button" class="btn btn-primary btn-block">View Data</button></a>
          </p>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="col-xs-12 col-md-6 col-lg-6">
  <div class="bs-callout bs-callout-primary">
    <h4>External Source Data Viewer (MySQL)</h4><br>
    <ul>
      <form method="post" action="{{url('/externalSourceView')}}">
        {{ csrf_field() }}
        <div class="form-group">
          <small class="form-text text-muted">Host Name.</small>
          <input type="text" class="form-control" name="host">
        </div>
        <div class="form-group">
          <small class="form-text text-muted">Port Number.</small>
          <input type="text" class="form-control" name="port">
        </div>
        <div class="form-group">
          <small class="form-text text-muted">Username.</small>
          <input type="text" class="form-control" name="db_username">
        </div>
        <div class="form-group">
          <small class="form-text text-muted">Password.</small>
          <input type="password" class="form-control" name="db_password">
        </div>
        <div class="form-group">
          <small class="form-text text-muted">Database Name.</small>
          <input type="text" class="form-control" name="db_name">
        </div>
        <div class="form-group">
          <small class="form-text text-muted">Table Name.</small>
          <input type="text" class="form-control" name="tab">
        </div>
        <input type="submit" value="View Data" class="btn btn-primary">
      </form>
    </ul>
  </div>
</div>


<!--/.row-->
@endsection
