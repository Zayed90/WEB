@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em></a></li>
    <li class="active">Tables</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Detail Table</h2>
  </div>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <a href="{{url('dataClustering')}}" class="btn btn-sm btn-info pull-right">Show Clustering</a>
  </div>
</div>

<hr>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
          <thead>
            <tr>
              <th data-field="id" data-sortable="true">PABRIK_ID</th>
              <th>NAMA</th>
              <th>ALAMAT</th>
              <th>NEGARA_ID</th>
              <th>ID_LAMA</th>
              <th>STATUS</th>
            </tr>
          </thead>
          @foreach($data as $row)
          <tr>
            <td>{{$row->PABRIK_ID}}</td>
            <td>{{$row->NAMA}}</td>
            <td>{{$row->ALAMAT}}</td>
            <td>{{$row->NEGARA_ID}}</td>
            <td>{{$row->ID_LAMA}}</td>
            <td>{{$row->STATUS}}</td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
</div>

<!--/.row-->
@endsection
