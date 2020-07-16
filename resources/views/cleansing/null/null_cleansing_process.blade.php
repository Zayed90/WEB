@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/pattern')}}">Pattern</a></li>
    <li class="active">Process</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Processing Pattern</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4>Result</h4>
  <hr>
  <pre>
    @if($isDataExist)
    @php
    ini_set('max_execution_time', 600);
    set_time_limit(0);
    $exec = 'C:\data-integration\pan.bat /file:"C:\data-integration\New_Currently_Using\web_'.$tipe.'\cleansing\null_cleansing.ktr" /param:"col='.$column.'" /param:"tab='.$table.'" /param:"db_host='.$host.'" /param:"db_name='.$db_name.'" /param:"db_username='.$db_username.'" /param:"db_password='.$db_password.'" /param:"db_port='.$port.'" /param:"ref='.$ref.'"';
    printf(shell_exec($exec));
    echo $exec;
    @endphp
      @else
      Ops, your database info is not correct
    @endif
  </pre>
  <br>
  @if($isDataExist)
  <a class="" href="{{url('cleansing/null/viewresult')}}"><button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="bt1 back btn-lg active"><i class="fa fa-file-powerpoint-o" style="font-size:25px;color:#000000"></i> View Results </button></a> &nbsp&nbsp
  @else
    <a href="{{route('cleansing_null')}}"><button type="button" class="btn btn-primary">Back</button></a>
  @endif
</div>


<!--/.row-->
@endsection
