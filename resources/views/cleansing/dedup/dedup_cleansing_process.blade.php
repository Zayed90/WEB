@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/pattern')}}">Deduplication</a></li>
    <li class="active">Process</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Processing Deduplication</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4>Result</h4>
  <hr>
  <pre>

    @php
    ini_set('max_execution_time', 600);
    set_time_limit(0);
    $exec = 'E:\KULIAH\SMT7\data-integration\pan.bat /file:"E:\KULIAH\SMT7\TA\DQM2015\pentaho file\New_Currently_Using\web_'.$tipe.'\cleansing\web_data_deduplicationcahya.ktr" /param:"column1='.$column1.'" /param:"column2='.$column2.'" /param:"table1='.$table1.'" /param:"table2='.$table2.'" /param:"host='.$host.'" /param:"db_name='.$db_name.'" /param:"db_username='.$db_username.'" /param:"db_password='.$db_password.'" /param:"port='.$port.'"';
    printf(shell_exec($exec));
    echo $exec;
    @endphp
  </pre>
  <br>
  <a href="{{url('/cleansing/pattern')}}"<button type="button" class="btn btn-primary">Back</button></a>

</div>


<!--/.row-->
@endsection
