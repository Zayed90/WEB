@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
			<li><a href="{{url('/home')}}"><em class="fa fa-home"></em></a></li>
    <li>Tables</li>
    <li>Monitoring</li>
    <li class="active">List Null/Blank rows</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Tabel Null / Blank</h2>
  </div>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <a href="{{url('monitoringAdmin')}}" class="btn btn-sm btn-info">back</a>
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
						        <th>TRADER_ID</th>
						        <th>NAMA</th>
						        <th>ALAMAT</th>
						        <th>NPWP</th>
						        <th>DAERAH_ID</th>
						        <th>KODEPOS</th>
						        <th>TELP</th>
						        <th>FAX</th>
						        <th>ID_LAMA</th>
						        
						    </tr>
						    </thead>
						    @foreach($data as $row)
	                	 	<tr>
	                	 		<td>{{$row->TRADER_ID}}</td>
	                	 		<td>{{$row->NAMA}}</td>
	                	 		<td>{{$row->ALAMAT}}</td>
	                	 		<td>{{$row->NPWP}}</td>
	                	 		<td>{{$row->DAERAH_ID}}</td>
	                	 		<td>{{$row->KODEPOS}}</td>
	                	 		<td>{{$row->TELP}}</td>
	                	 		<td>{{$row->FAX}}</td>
	                	 		<td>{{$row->ID_LAMA}}</td>
	                	 	</tr>
	                	 @endforeach
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->
@endsection