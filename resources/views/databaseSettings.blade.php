@extends('template')
@section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
      <li class="active">Database Settings</li>
    </ol>
  </div><!--/.row-->
  
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Database Connection Settings</h1>
    </div>    
  </div><!--/.row-->
  @if(!session()->get('mysqlConnect'))
  <div class="alert bg-warning" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Ops, Cannot Save Mysql Configuration - Database Not Connected, Please Check Your Input Data <a href="#" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>
  {{session()->put('mysqlConnect', true)}}
  @endif
  @if(!session()->get('pgsqlConnect'))
  <div class="alert bg-warning" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Ops, Cannot Save PosgreSql Configuration - Database Not Connected, Please Check Your Input Data <a href="#" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>
  {{session()->put('pgsqlConnect', true)}}
  @endif			
<div style="margin-left: 100px">
  <div class="col-lg-8">
  <div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#mysql" aria-controls="mysql" role="tab" data-toggle="tab">MySQL</a></li>
      <li role="presentation"><a href="#postgre" aria-controls="postgre" role="tab" data-toggle="tab">PostgreSQL</a></li>
    </ul>
    <form method="post" action="{{url('/databaseUpdate')}}">
    {{ csrf_field() }}
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="mysql">
        <h4>Mysql Connection</h4>
            <div class="form-group">
                    <small class="form-text text-muted">Host Name.</small>
            <input type="text" class="form-control" name="host_mysql" value="{{ $results_mysql[0]->hostname }}">
                  </div>
            <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <small class="form-text text-muted">Port Number.</small>
                        <input type="text" class="form-control" name="port_mysql" value="{{ $results_mysql[0]->port }}">
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <small class="form-text text-muted">Database Name.</small>
                        <input type="text" class="form-control" name="db_name_mysql" value="{{ $results_mysql[0]->db_name }}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <small class="form-text text-muted">Username.</small>
                        <input type="text" class="form-control" name="db_username_mysql" value="{{ $results_mysql[0]->db_username }}">
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <small class="form-text text-muted">Password.</small>
                        <input type="password" class="form-control" name="db_password_mysql" value="{{ $results_mysql[0]->db_password }}">
                      </div>
                    </div>
                  </div>


      </div>
      <div role="tabpanel" class="tab-pane" id="postgre">
        <h4>PostgreSQL Connection</h4>
            <div class="form-group">
                    <small class="form-text text-muted">Host Name.</small>
                    <input type="text" class="form-control" name="host_postgre" value="{{ $results_postgre[0]->hostname }}">
                  </div>
            <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <small class="form-text text-muted">Port Number.</small>
                        <input type="text" class="form-control" name="port_postgre" value="{{ $results_postgre[0]->port }}">
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <small class="form-text text-muted">Database Name.</small>
                        <input type="text" class="form-control" name="db_name_postgre" value="{{ $results_postgre[0]->db_name }}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <small class="form-text text-muted">Username.</small>
                        <input type="text" class="form-control" name="db_username_postgre" value="{{ $results_postgre[0]->db_username }}">
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <small class="form-text text-muted">Password.</small>
                        <input type="password" class="form-control" name="db_password_postgre" value="{{ $results_postgre[0]->db_password }}">
                      </div>
                    </div>
                  </div>

      </div>
    </div>
  </div>
  <input type="submit" value="Save Settings" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit">
  </form>
</div>
</div> 

@endsection