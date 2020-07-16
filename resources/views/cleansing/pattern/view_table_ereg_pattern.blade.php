@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/pattern')}}">Pattern</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->
<a class="" href="{{url('cleansing/pattern')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-left:29px;margin-top:20px;margin-bottom:20px;"type="button"class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back</button></a> &nbsp&nbsp

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Table EREG Pattern</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4 style="margin-left:20px;">Result & Information</h4>

 
  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
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

          </div>
        </div>
      </div>
    </div>
  </div>

  <!--/.row-->
  @endsection
<style>
.caw {
  color: black;
  border-bottom: 5px double  #30A5FF; 
  margin:6px;
  margin-left:10px;
}
.wrapper.overflow {
  overflow-y: scroll;
  display: inline-block;
}
</style>