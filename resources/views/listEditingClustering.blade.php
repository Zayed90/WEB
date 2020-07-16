@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
			<li><a href="{{url('/home')}}"><em class="fa fa-home"></em></a></li>
    <li>Tables</li>
    <li>List Clustering</li>
    <li class="active">Edit Clustering</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">What will you choose ? </h2>
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
				<form action="{{url('/testing/'.$id)}}" method="post" class="form">
				{{csrf_field()}}
					<table data-toggle="table" >
						    <thead>
						    <tr>
						        <th data-field="id" data-sortable="true">PABRIK_ID</th>
						        <th>NAMA</th>
						        <th>Select</th>
						    </tr>
						    </thead>
						    <!-- ini isinya ID pabrik n NAMA yang sesuai dengan apa yg diklik pada halaman listClustering.php beserta banyaknya -->
	                	 	<!-- <tr>
	                	 		<td>269</td>
	                	 		<td>Access Business Group LLC.</td>
	                	 	</tr>
	                	 	<tr>
	                	 		<td>3823</td>
	                	 		<td>Access Business Group LLC</td>
	                	 	</tr> -->
	                	 	@foreach($data as $row)
	                	 	<tr>
	                	 		<td>{{$row->PABRIK_ID}}</td>
	                	 		<td>{{$row->NAMA}}</td>
	                	 		<td><input type="radio" name="data" class="form-control" value="{{$row->NAMA}}"></td>
	                	 	</tr>
	                	 	@endforeach
					</table>
					<br>
					<!-- Save ini isinya SQL update untuk tabel data_nama -->
              		<button type="submit" class="btn btn-sm btn-info pull-right" id="btnsave">Update data</button>
				</form>			
			</div>
		</div><!--/.row-->
@endsection
