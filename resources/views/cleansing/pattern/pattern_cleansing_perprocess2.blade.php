@extends('template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">
<ol class="breadcrumb">
  <li class="active"><a href="{{url('/home')}}"><em class="fa fa-home"></em> Dashboard</a></li>
    <li><a href="{{url('/cleansing/pattern/index')}}">Choose Modul</a></li>
    <li >All Cleansed Process</a></li>

  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h4 class="page-header"><strong>Result Process All Cleansed ...</strong></h4>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
<a class="" href="{{url('cleansing/pattern/all_cleansed')}}"><button type="button"class=" siti btn-lg active"><i class="fa fa-file-powerpoint-o" style="font-size:25px;color:#000000"></i> See the Results</button></a> &nbsp&nbsp
          <hr>
  <pre>
    
    @php
    ini_set('max_execution_time', 600);
    set_time_limit(0);
    $exec = 'C:\data-integration\pan.bat /file:"C:\data-integration\New_Currently_Using\web_'.$tipe.'\cleansing\per_pattern_cleansing.ktr" /param:"col='.$column.'" /param:"tab='.$table.'" /param:"host='.$host.'" /param:"db_name='.$db_name.'" /param:"db_username='.$db_username.'" /param:"db_password='.$db_password.'" /param:"port='.$port.'" /param:"filter='.$filter.'" /param:"regx='.$pattern.'"';
    printf(shell_exec($exec));
    echo $exec;
    @endphp
  </pre>
  <br>
</div>
<!--/.row-->
@endsection
