@extends('template')
@section('content')

<div class="row">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em></a></li>
      <li class="active">Import Data</li>
    </ol>
  </div><!--/.row-->
  
  <div class="row">
    <div class="col-lg-6">
      <h1 class="page-header">Import from External Source</h1>
      @if(session()->get( 'id' )==1)
      <div class="alert bg-success" role="alert"><em class="fa fa-lg fa-check">&nbsp;</em><i> Import Data Succesful, See result</i> <a href="">as</a>     </div>
      @endif
    </div>
  </div><!--/.row-->
<div class="col-xs-12 col-md-6 col-lg-6">
    <div class="panel panel-primary">
        <div class="panel-heading">Import Data Form CSV File</div>
        <div class="panel-body">
      <ul>
        <form method="post" action="{{url('/importcsv')}}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">  
            <input type="file" class="form-control" name="host" accept=".csv">
          </div>
         
          <input type="submit" value="Import" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" name="submit">
        </form>
      </ul>
        </div>
    </div>
  </div>
@endsection