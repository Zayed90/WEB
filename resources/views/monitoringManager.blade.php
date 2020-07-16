@extends('templateManager')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="#"><em class="fa fa-home"></em></a></li>
    <li class="active">Monitoring</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Monitoring</h1>
  </div>
</div><!--/.row-->


<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
          <div class="panel-heading" align="center">History of Monitoring</div>
					<div class="panel-body">
						<table data-toggle="table" data-search="true" data-pagination="true">
						    <thead>
                <tr>
                    <th>NAMA TABEL</th>
                    <th>KOLOM TABEL</th>
                    <th>JUMLAH CLUSTERING</th>
                    <th>JUMLAH NULL/BLANK</th>
                    <th>DIPERBARUI PADA</th>
                </tr>
                </thead>
                @foreach($data as $row)
                <tr>
                    <td>{{$row->NAMA_TABEL}}</td>
                    <td>{{$row->KOLOM_TABEL}}</td>
                    <td>{{$row->JUMLAH_CLUSTERING}}</td>
                    <td>{{$row->JUMLAH_NULL}}</td>
                    <td>{{$row->UPDATE_AT}}</td>
                </tr>
                @endforeach
						</table>
					</div>
				</div>
			</div>
</div><!--/.row-->
@endsection
