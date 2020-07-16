@extends('template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="row">
  <ol class="breadcrumb">
  <li class="active"><a href="{{url('/home')}}"><em class="fa fa-home"></em> Dashboard</a></li>
    <li><a href="{{url('/cleansing/pattern/index')}}">Choose Modul</a></li>
    <li><a href="{{url('cleansing/pattern')}}">Choose Pattern</a></li>
    <li> Punctuation</li>

    </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><strong>View the Result</strong></h3>
  </div>
</div><!--/.row-->
<br><br>
  <form method="post" action="{{ url('/cleansing/pattern/choose-pattern') }}" enctype="multipart/form-data">
    <div class="col-xs-12 col-md-6 col-lg-12">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-xs-12 col-md-6 col-lg-12">
            <div class="form-group">
            <a class="" href="{{url('cleansing/pattern')}}"><button type="button"data-toggle="modal" data-target=".bd-example-modal-lg"class="bt1 siti btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back To Choose Pattern</button></a> &nbsp&nbsp
      </div>
        
          <table style="width:50%;background:#F1F4F7;" data-toggle="table"  data-pagination="true">
            <thead>
              <tr>
              <center><th data-field="id" data-sortable="true">Running At</th></center>
                <th>Action</th>
              </tr>
            </thead>
            @foreach($results as $row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success" >
              @else
              <tr>
                @endif
               <td> <button type="button" class="bt1 caw"><strong> {{$row->created_at}}</strong></button></td>
                <td><a href="{{route('view_choose_pattern',['id'=>$row->id_running])}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button" class="bt1 pronow">View The Results </button></a></td>
              </tr>
              @endforeach
            </table>

  <!--/.row-->
  @endsection
