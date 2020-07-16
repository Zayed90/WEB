@extends('template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">
  <ol class="breadcrumb">
    <li class="active"><a href="{{url('/home')}}"><em class="fa fa-home"></em> Dashboard</a></li>
    <li >Choose Modul</a></li>

  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Cleansing Package</h1>
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
              <h4><strong>Choose Modul to Cleansing the Data</strong></h4>
              <br>
              <a class="" href="{{url('/cleansing_mdm/punctuation')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg"type="button"class="buti dua btn-lg active"><i class="fa fa-file-powerpoint-o" style="font-size:25px;"></i> Punctuation<br><br> <h6 style="color:white;">Delete punctuation</h6> </button></a> &nbsp&nbsp
              <a class="" href="{{url('/cleansing_mdm/uppercase')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button" class="buti tiga btn-lg active"><i class="fa fa-repeat" style="font-size:25px;"></i> Change Uppercase<br><br> <h6 style="color:white;">Change to Uppercase</h6></button></a>&nbsp&nbsp
              <a class="" href="{{url('/cleansing_mdm/whitespace')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button" class="buti empat btn-lg active"><i class="fa fa-eraser" style="font-size:25px;"></i> Remove Whitespace<br><br> <h6 style="color:white;">Remove Split Whitespace</h6></button></a>&nbsp&nbsp                        
            </div>
          </div>
        </div>    
    </div>
@endsection