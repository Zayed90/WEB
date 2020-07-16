@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/outlier')}}">Outlier</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Outlier</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4>ID Running : {{ $id_running }}</h4>
  <a href="{{route('outlier')}}"<button type="button" class="btn btn-success">Back</button></a>
  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>Data 1</th>
                <th>Data 2</th>
                <th>Data 3</th>
                <th>Outlier</th>
              </tr>
            </thead>
            @foreach($results as $row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->data_1}}</td>
                <td>{{$row->data_2}}</td>
                <td>{{$row->data_3}}</td>
                <td>{{$row->outlier}}</td>
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
