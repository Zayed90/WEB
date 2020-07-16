@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/clustering')}}">Multi Proccess</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Result</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4>Result & Information</h4>
  <pre>
    ID Running : {{ $id_running }}
    First Proccess : {{ $data[0]->proccess }}
    Result In  : {{ $data[1]->proccess }}
  </pre>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
          <thead>
            <tr>
              <th>Step</th>
              <th>Proccess</th>
              <th>More</th>
            </tr>
          </thead>
          @for($i = 0; $i < 2; $i++)
          <tr>  
              <td>{{ $i+1 }}</td>
              <td>{{ $data[$i]->proccess }}</td>
              <td><a href={{$link[$i]}} <button type="button" class="btn btn-success">Detail Result</button></a></td>
            
            @endfor
        
        
        </tr>
          </table>
        </div>
      </div>
      <a href="{{route('clustering')}}"<button type="button" class="btn btn-block btn-success">Back</button></a>
    </div>
  </div>
</div>

<!--/.row-->
@endsection
