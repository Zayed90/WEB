@extends('template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="row">
  <ol class="breadcrumb">
  <li class="active"><a href="{{url('/home')}}"><em class="fa fa-home"></em> Dashboard</a></li>
    <li><a href="{{url('/cleansing/pattern/index')}}">Choose Modul</a></li>
    <li >Choose Pattern</a></li>
    </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><strong>&nbsp&nbspChoose Pattern Modul</strong></h3>
  </div>
<br><br>
<a class="" href="{{url('cleansing/pattern/index')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg"type="button"class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000;margin-left:20px;"></i> &nbsp Back To Choose Modul</button></a> &nbsp&nbsp
            <a class="" href="{{url('cleansing/pattern/pattern_punctuation')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg"type="button"class="bt1 skip btn-lg active"> Skip This Modul &nbsp <i class="fa fa-angle-double-right" style="font-size:25px;color:#000000"></i></button></a> &nbsp&nbsp
            
<div class="row">
<br><br>
<button formaction="{{ url('/cleansing/pattern/') }}" style="margin-left:20px"class="ciw" onclick="myFunction()">Show Table</button>
      <div id="myDIV">
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
<thead>
<tr>
<th>Nomor Produk</th>
<th>Nomor Izin Edar (NIE)</th>
<th>Pattern NIE</th>
</tr>
</thead>
@foreach($name as $data)
<tr class="success">
<td>{{ $data->NOMOR}}</td>
<td>{{ $data->Pattern_NIEhuruf}}</td>
<td>{{ $data->Pattern_NIE_All}}</td>
</tr>
@endforeach
            </table>
          </div>
          </div>


  <form method="post" action="{{ url('/cleansing/pattern/choose-pattern2') }}" enctype="multipart/form-data">
    <div class="col-xs-12 col-md-6 col-lg-12">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-xs-12 col-md-6 col-lg-12">
            <div class="form-group">
          <br><br>
            </div>
            </div>    
      </div>
      
      <h3>&nbsp&nbspDatabase Source</h3>
      <div class="select">

              <select class="select" name="tipe_database" id="selectDB" onclick="selectDatabase()">
              <option value="mysql">MySQL</option>
                <option value="postgre">PostgreSQL</option>
                <option value="CSV">CSV</option>
              </select>
      </div>
      <small class="form-text text-muted" id="small">&nbsp&nbsp&nbsp&nbsp<strong>Settings Database Connection</strong> <a href="{{ url('/database') }}">Setting Here</a></small>
      <div class="bs-callout bs-callout-primary">
      
      <label style="margin:20px">Show Table  <a href="{{ url('/cleansing/pattern/viewtable') }}"> Here</a></small></label>
      <br><label style="margin:20px">Table & Column Setting</label><br>
      <form class="w3-container">
      <input id="tableinput" class="w3-input w3-animate-input" type="text" placeholder="Enter Table name to be used in this process." name="table" style="width:50%"><br>
      <input class="w3-input  w3-animate-input" placeholder="Enter column name to be used in this process." name="column" type="text" style="width:50%">
      </form><br><br>
      <input type="submit" formaction="{{ url('/cleansing/pattern/choose-pattern') }}"value="All Cleansed Now" class="bt1 bitu" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit">

      <input type="submit" value="Use Modul to Cleansing" class="bt1 biti" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit">

      </div>
    </div>
  </form>
</div>
  @endsection
  <style>
  #myDIV {
  width: 100%;
  text-align: center;
  background-color: white;
  display: none;
}
</style>
<script>
function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>