@extends('template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">
  <ol class="breadcrumb">
    <li class="active"><a href="{{url('/home')}}"><em class="fa fa-home"></em> Dashboard</a></li>
    <li >Choose Modul</a></li>
    <!-- <li><a href="{{url('/Cleansing/pattern/index')}}">Punctuation</a></li>
    <li><a href="{{url('#')}}">Delete Space</a></li>
    <li><a href="{{url('#')}}">Change Pattern</a></li>
    <li><a href="{{url('#')}}">Facetting Pattern</a></li> -->

  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Cleansing Package: Pattern</h1>
  </div>
</div><!--/.row-->
<br><br>
<div class="row">
  <form method="post" action="{{ url('/cleansing/pattern/choose-pattern') }}" enctype="multipart/form-data">
    <div class="col-xs-12 col-md-6 col-lg-12">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-xs-12 col-md-6 col-lg-12">
            <div class="form-group">
             <center><h4><strong>Choose Modul to Cleansing the Data</strong></h4></center>
              <br>
              <center>
              <a class="" href="{{url('cleansing/pattern')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg"type="button"class="buti satu btn-lg active"><i class="fa fa-paperclip" style="font-size:25px;"></i> Choose Pattern<br><br> <h6 style="color:white;">Choose pattern from profiling</h6> </button></a> &nbsp&nbsp
              <a class="" href="{{url('cleansing/pattern/pattern_punctuation')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg"type="button"class="buti dua btn-lg active"><i class="fa fa-file-powerpoint-o" style="font-size:25px;"></i> Punctuation<br><br> <h6 style="color:white;">Delete punctuation in pattern</h6> </button></a> &nbsp&nbsp
              <a class="" href="{{url('cleansing/pattern/pattern_change')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button" class="buti tiga btn-lg active"><i class="fa fa-repeat" style="font-size:25px;"></i> Change Pattern<br><br> <h6 style="color:white;">Change the format of the pattern</h6></button></a>&nbsp&nbsp
              <a class="" href="{{url('cleansing/pattern/delete_space')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button" class="buti empat btn-lg active"><i class="fa fa-eraser" style="font-size:25px;"></i> Delete Space<br><br> <h6 style="color:white;">Delete the Space of the pattern</h6></button></a>&nbsp&nbsp
              <!-- <a class="" href="{{url('cleansing/pattern/facetting_pattern')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button" class="buti empat btn-lg active"><i class="fa fa-list" style="font-size:25px;"></i> Facetting Pattern<br><br> <h6 style="color:white;">Count the amount of pattern</h6></button></a> -->
            </center>
            </div>
           </div>    
      </div>
      @endsection