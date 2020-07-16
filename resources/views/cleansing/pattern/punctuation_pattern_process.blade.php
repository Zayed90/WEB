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
    <h1 class="page-header">Processing Punctuation</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
<a class="" href="{{url('cleansing/pattern/pattern_punctuation')}}"><button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back </button></a> &nbsp&nbsp

<div class="bs-callout bs-callout-success">
  <h4>Result</h4>
  <hr>
  <pre>
  @php
    ini_set('max_execution_time', 600);
    set_time_limit(0);
    $exec = 'C:\data-integration\pan.bat /file:"C:\data-integration\New_Currently_Using\web_'.$tipe.'\polosan\udah_bisa\hapus_punctuation.ktr" /param:"id_running='.$id_running.'" /param:"col='.$column.'" /param:"tab='.$table.'" /param:"host='.$host.'" /param:"db_name='.$db_name.'" /param:"db_username='.$db_username.'" /param:"db_password='.$db_password.'" /param:"port='.$port.'" /param:"regx='.$pattern.'"';
    printf(shell_exec($exec));
    echo $exec;
    @endphp
  </pre>
  
</div>
<!--/.row-->
@endsection