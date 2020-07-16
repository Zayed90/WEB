@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/pattern')}}">Pattern</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->
<a class="" href="{{url('cleansing/null/index')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-left:29px;margin-top:20px;margin-bottom:20px;"type="button"class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back</button></a> &nbsp&nbsp
<a class="" href="{{url('cleansing/null/')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button"class="bt1 skip btn-lg active"> Next to Null Processing  &nbsp <i class="fa fa-angle-double-right" style="font-size:25px;color:#000000"></i></button></a> &nbsp&nbsp

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Table EREG Merk</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4 style="margin-left:20px;">Table Information</h4>
  <button formaction="#" style="margin-left:23px"class=" ciw"> Table Name<strong> TB_EREG_MERK</strong></button>
  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
<thead>
<tr>
<th><button formaction="#" class=" cow"> <strong> Table: PRODUK_ID</strong></button></th>
<th><button formaction="#" class=" cew"> <strong> Table: NAMA_PABRIK</strong></button></th>
<th><button formaction="#" class=" ciw"> <strong> Table: MERK</strong></button></th>
<th><button formaction="#" class=" caw"> <strong> Table: NAMA_PRODUK</strong></button></th>
</tr>
</thead>
@foreach($name as $data)
<tr class="success">
<td>{{ $data->PRODUK_ID}}</td>
<td>{{ $data->NAMA_PABRIK}}</td>
<td>{{ $data->MERK}}</td>
<td>{{ $data->NAMA_PRODUK}}</td>
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