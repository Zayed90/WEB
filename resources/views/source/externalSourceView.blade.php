@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li class="active">External Data Source</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View External Data Source</h1>
  </div>
</div><!--/.row-->
<div class="bs-callout bs-callout-success">
  <h4>Host Name : {{ $host }}</h4>
  <h4>Database Name : {{ $database }}</h4>
  <h4>Port Number : {{ $port }}</h4>
  <h4>Table Name : {{ $table }}</h4>
  <a href="{{url('/home')}}"<button type="button" class="btn btn-success">Back</button></a>
  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                @for ($i = 0; $i < count($column_detail); $i++)
                <th>{{ $column_detail[$i] }}</th>
                @endfor
              </tr>
            </thead>
            @foreach($results as $row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                @for ($i = 0; $i < count($column_detail); $i++)
                @php $row_name = $column_detail[$i].'' @endphp
                <td>{{ $row->$row_name }}</td>
                @endfor
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
