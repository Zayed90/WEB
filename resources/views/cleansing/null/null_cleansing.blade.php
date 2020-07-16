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
  <a class="" href="{{url('cleansing/null/index')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" style="margin-left:29px;"type="button"class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back</button></a> &nbsp&nbsp

<br><br>
</div><!--/.row-->

<div class="row">
  <form method="post" action="{{ url('/cleansing/null/process') }}" enctype="multipart/form-data">
    <div class="col-xs-12 col-md-6 col-lg-12">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-xs-12 col-md-6 col-lg-12">
            <div class="form-group">
            </div>
            </div>    
      </div>
      <div class="bs-callout bs-callout-primary">
        <div class="row">
          
        <div class="form-group">
        <label style="margin:20px">Show Table  <a href="{{ url('/cleansing/null/viewtable') }}"> Here</a></small></label>
          <br><label style="margin:20px">Table & Column Setting</label><br>
          <input class="w3-input w3-animate-input" type="text" id="tableinput" name="table" placeholder="Enter table name to be used in this process." type="text" style="width:50%">
          <input class="w3-input w3-animate-input" type="text" name="column" placeholder="Enter column name to be used in this process."  style="width:50%">
          <!-- <input class="w3-input w3-animate-input" type="text" name="ref" class="form-control" placeholder="Enter column refrance to cleansing column target." style="width:50%"> -->

          </form><br><br>
      </div>
      <input type="submit" formaction="{{ url('/cleansing/null/next_process') }}" value="Next Process"  class="bt1 bitu" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit">
        <!-- <input type="submit" formaction="{{ url('/cleansing/null/process') }}" value="Execution"  class="bt1 bitu" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit"> -->

      </div>
    </div>
  </form>
</div>
  @endsection
