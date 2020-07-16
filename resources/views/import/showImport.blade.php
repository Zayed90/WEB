@extends('template')
@section('content')

<div class="row">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em></a></li>
      <li class="active">Show Import Data</li>
    </ol>
  </div><!--/.row-->
  
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Show Data Import</h1>
    </div>
  </div><!--/.row-->
<div class="bs-callout bs-callout-success">

    <hr>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
              <thead>
                <tr>
                  <th>Table Name</th>
                  <th data-field="id" data-sortable="true">Running At</th>
                  <th>Result</th>
                </tr>
              </thead>
              @foreach($res as $row)
              @if(($loop->first) && (!empty($_GET['done'])))
              <tr class="success">
                @else
                <tr>
                  @endif
                  <td>{{$row->table_name}}</td>
                  <td>{{$row->create_time}}</td>
                <td><a href="importResult/{{ $row->table_name }}"<button type="button" class="btn btn-success">See Result</button></a></td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection