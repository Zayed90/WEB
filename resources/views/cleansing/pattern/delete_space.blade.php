@extends('template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="row">
  <ol class="breadcrumb">
  <li class="active"><a href="{{url('/home')}}"><em class="fa fa-home"></em> Dashboard</a></li>
    <li><a href="{{url('/cleansing/pattern/index')}}">Choose Modul</a></li>
    <li><a href="{{url('/cleansing/pattern')}}">Choose Pattern</a></li>
    <li><a href="{{url('/cleansing/pattern/pattern_punctuation')}}">Punctuation</a></li>
    <li><a href="{{url('/cleansing/pattern/pattern_change')}}">Change Pattern</a></li>
    <li>Delete Space</a></li>

    </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><strong>Modul Delete Space Pattern</strong></h3>
  </div>
</div><!--/.row-->
<br><br>
<div class="row">
  <form method="post" action="{{ url('/cleansing/pattern/choose-pattern2') }}" enctype="multipart/form-data">
    <div class="col-xs-12 col-md-6 col-lg-12">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-xs-12 col-md-6 col-lg-12">
            <div class="form-group">
            <a class="" href="{{url('cleansing/pattern/pattern_change')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button"class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back To Change Pattern</button></a> &nbsp&nbsp
            <!-- <a class="" href="{{url('cleansing/pattern/facetting_pattern')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button"class="bt1 dui btn-lg active"> Skip This Modul &nbsp <i class="fa fa-angle-double-right" style="font-size:25px;color:#000000"></i></button></a> &nbsp&nbsp -->

            </div>
            </div>    
      </div>
     
      <div class="panel panel-default">
        <div class="panel-body">
          <center>  <h4><strong>Choose the Result to change the pattern</strong></h4> </center>
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>Id</th>
                <th data-field="id" data-sortable="true">Running At</th>
                <th>Action</th>
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
                <td><a href="{{route('view_delete_space',['id'=>$row->id_running])}}"><button type="button" data-toggle="modal" data-target=".bd-example-modal-lg"class="btn btn-warning">Delete Space in Pattern</button></a></td>
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