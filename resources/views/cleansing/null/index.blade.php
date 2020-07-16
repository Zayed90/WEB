@extends('template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">
  <ol class="breadcrumb">
    <li class="active"><a href="{{url('/home')}}"><em class="fa fa-home"></em> Dashboard</a></li>
    <li >Null Cleansing Modul</a></li>
    <!-- <li><a href="{{url('/Cleansing/pattern/index')}}">Punctuation</a></li>
    <li><a href="{{url('#')}}">Delete Space</a></li>
    <li><a href="{{url('#')}}">Change Pattern</a></li>
    <li><a href="{{url('#')}}">Facetting Pattern</a></li> -->

  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Cleansing Package: Null</h1>
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
             <center><h4><strong>Null Cleansing Modul</strong></h4></center>
              <br>
              <center>
              <a class="" href="{{url('cleansing/null/viewtable')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg"type="button"class="buti enam btn-lg active"><i class="fa fa-table" style="font-size:25px;"></i> Show Table<br><br> <h6 style="color:white;">Show table EREG MERK</h6> </button></a> &nbsp&nbsp
              <a class="" href="{{url('cleansing/null')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg"type="button"class="buti tujuh btn-lg active"><i class="fa fa-minus-square-o" style="font-size:25px;"></i> Null Processing<br><br> <h6 style="color:white;">Do the Null Processing</h6> </button></a> &nbsp&nbsp
              <a class="" href="{{url('cleansing/null/viewresult')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg"type="button"class="buti delapan btn-lg active"><i class="fa fa-list-alt" style="font-size:25px;"></i> Null Result<br><br> <h6 style="color:white;">View Already Running Null</h6> </button></a> &nbsp&nbsp

              </center>
            </div>
           </div>    
      </div>
      @endsection