@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li class="active">Cleansing</li>
    <li><a href="{{url('/cleansing/pattern')}}">Pattern</a></li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Cleansing Null</h1>
  </div>
</div><!--/.row-->
<a class="" href="{{url('cleansing/null/index')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button"class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back</button></a> &nbsp&nbsp
            
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
                  <td><a href="{{route('cleansing_null_view',['id'=>$row->id_running])}}"><button type="button" class="btn btn-success">See Result</button></a></td>
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
