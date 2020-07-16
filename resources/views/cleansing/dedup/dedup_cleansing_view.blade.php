@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/dedup')}}">Deduplication</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Deduplication</h1>
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
    First Table name : {{ $datasource_detail['tb1'] }}
    Second Table name : {{ $datasource_detail['tb2'] }}
    Column Name(First Table) : {{ $datasource_detail['col1'] }}
    Column Name(Second Table) : {{ $datasource_detail['col2'] }}
  </pre>

  <hr>
  <div class="row">
    <div class="col-lg-12">
        <!-- <form method="post" action="{{ url('/cleansing/dedup/manualProcessSub') }}">
          {{ csrf_field() }}
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
              <div class="form-group">
                <label>Deduplication</label>
                <select class="form-control" name="pattern" id="selectDB" onclick="selectDatabase()">
                    @foreach($dedup as $i=>$p)
                  <option value={{$p->column_name_1}}>{{$p->column_name_1}}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted" id="small">Settings Database Connection <a href="{{ url('/database') }}">Here</a></small>

              </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">String to Clean</label>
                    <input type="text" class="form-control" name="old_string">
                  <input type="hidden" class="form-control" name="id_running" value="{{$id_running}}">
                    <small class="form-text text-muted">Enter table name to be used in this process.</small>
                  </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">New Pattern</label>
                        <input type="text" class="form-control" name="new_string">
                        <small class="form-text text-muted">Enter table name to be used in this process.</small>

                      </div>
                      <input type="checkbox" name="cleansed" value="cleansed"> Accept This to Cleansed String<br>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group" style="margin-top: 8px">
                          <small class="form-text text-muted">.</small>

                          <button class="btn btn-success btn-block">Next</button>
                      </div>
                    </form> -->
                  </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-body">
            <table data-toggle="table" data-show-refresh="true" data-search="true" data-page-size="20" data-pagination="true">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Nama</th>
                </tr>
              </thead>
              @foreach($results as $i=>$row)
              @if(($loop->first) && (!empty($_GET['done'])))
              <tr class="success">
                @else
                <tr>
                  @endif
                  <td>{{$row->id}}</td>
                  <td>{{$row->name}}</td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
      </div>
  </div>


  <!--/.row-->
  @endsection
