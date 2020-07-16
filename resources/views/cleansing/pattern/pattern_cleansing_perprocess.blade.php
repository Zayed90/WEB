@extends('template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">
<ol class="breadcrumb">
  <li class="active"><a href="{{url('/home')}}"><em class="fa fa-home"></em> Dashboard</a></li>
    <li><a href="{{url('/cleansing/pattern/index')}}">Choose Modul</a></li>
    <li>Choose Pattern</a></li>

  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h4 class="page-header"><strong>Result after choose pattern ...</strong></h4>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
<a class="" href="{{url('cleansing/pattern/result_choose_pattern')}}"><button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="bt1 back btn-lg active"><i class="fa fa-file-powerpoint-o" style="font-size:25px;color:#000000"></i> View Results </button></a> &nbsp&nbsp
  <a class="" href="{{url('cleansing/pattern/pattern_punctuation')}}"><button type="button"data-toggle="modal" data-target=".bd-example-modal-lg" class="bt1 skip btn-lg active"><i class="fa fa-eraser" style="font-size:25px;color:#000000"></i> Next to Punctuation Modul</button></a> &nbsp&nbsp
  <hr>
  <pre>
    
    @php
    ini_set('max_execution_time', 600);
    set_time_limit(0);
    $exec = 'C:\data-integration\pan.bat /file:"C:\data-integration\New_Currently_Using\web_'.$tipe.'\tes\per_pattern_cleansing2.ktr" /param:"col='.$column.'" /param:"tab='.$table.'" /param:"host='.$host.'" /param:"db_name='.$db_name.'" /param:"db_username='.$db_username.'" /param:"db_password='.$db_password.'" /param:"port='.$port.'" /param:"filter='.$filter.'" /param:"regx='.$pattern.'"';
    printf(shell_exec($exec));
    echo $exec;
    @endphp
  </pre>
  <br>
</div>
<!--/.row-->
@endsection