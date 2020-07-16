@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
			<li><a href="#"><em class="fa fa-home"></em></a></li>
    <li>Tables</li>
    <li class="active">Clustering List</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Clustering Table</h2>
    <h5><kbd> Total cluster is {{$jml_clustering}} </kbd></h5>
  </div>
</div><!--/.row-->

<!-- <div class="row">
  <div class="col-lg-12">
    <a href="{{url('dataSource')}}" class="btn btn-sm btn-info">back</a>
  </div>
</div> -->

<!-- <hr> -->

<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					@if(Session::has('status'))
						<h3 style="color: red">{{Session::get('status')}}</h3>
					@endif
						<table data-toggle="table" data-search="true" data-pagination="true">
						    <thead>
						    <tr>
						        <th>FINGERPRINT</th>
						        <th>JUMLAH</th>
						    </tr>
						    </thead>
						    @foreach($data as $row)
	                	 	<tr>
	                	 		<td name="fingerprint"> <a href="{{url('testing/'.$row->FINGERPRINT)}}">{{$row->FINGERPRINT}}</a> </td>
	                	 		<td>{{$row->JUMLAH}}</td>
	                	 	</tr>
	                	 @endforeach
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->
@endsection
