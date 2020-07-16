@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/pattern')}}">Pattern</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Null Processing</h1>
  </div>
  <a class="" href="{{url('cleansing/null/')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-left:29px;"type="button"class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back</button></a> &nbsp&nbsp
  <a class="" href="{{url('cleansing/null/viewresult')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-left:689px;"type="button"class="bt1 skip btn-lg active"><i class="fa fa-angle-double-right" style="font-size:25px;color:#000000"></i> &nbsp Show Result</button></a> &nbsp&nbsp

<br><br><br>
</div><!--/.row-->
<button formaction="#" class="bt1 caw"> Table Name:<strong> {{ $table }}</strong></button>
<button formaction="#" class="bt1 ciw"> Column Name:<strong> {{ $column }}</strong></button>

<div class="bs-callout bs-callout-success">
<h5><strong>&nbsp&nbsp Table and Column Information</strong></h5>
<form method="post" action="{{ url('/cleansing/null/process') }}" enctype="multipart/form-data">
    <div class="col-xs-12 col-md-6 col-lg-12">
        {{ csrf_field() }}

<div class="select">

<select class="select" name="tipe_database" id="selectDB" onclick="selectDatabase()">
<option value="mysql">MySQL</option>
  <option value="postgre">PostgreSQL</option>
  <option value="CSV">CSV</option>
</select>
</div>
<<<<<<< HEAD
<small class="form-text text-muted" id="small">Settings Database Connection <a href="{{ url('/database') }}">Here</a></small>
=======
>>>>>>> haidar

<div class="bs-callout bs-callout-primary">
        <div class="row">
          
        <div class="form-group">
<<<<<<< HEAD
        <input class="w3-input w3-animate-input"  type="hidden" id="tableinput" readonly  name="table" value="{{$table}}" style="width:50%">
        <input class="w3-input w3-animate-input"  type="hidden" name="column" readonly  value="{{$column}}"  style="width:50%">
        <input class="w3-input w3-animate-input" type="text" name="ref" class="form-control" placeholder="Enter column Reference to cleansing column target." style="width:50%">
=======
        <input class="w3-input w3-animate-input"  type="text" id="tableinput" name="table" value="{{$table}}" style="width:50%">
        <input class="w3-input w3-animate-input"  type="text" name="column" value="{{$column}}"  style="width:50%">
        <input class="w3-input w3-animate-input" type="text" name="ref" class="form-control" placeholder="Enter column refrance to cleansing column target." style="width:50%">
>>>>>>> haidar
       
        </form><br><br>
        </div>
        <input type="submit" formaction="{{url('/cleansing/null/process') }}" value="Execution"  class="bt1 bitu" data-toggle="modal" data-target=".bd-example-modal-lg" style="width:50%" name="submit">
<br><br><br>
  @endsection