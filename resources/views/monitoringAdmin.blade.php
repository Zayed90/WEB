@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em></a></li>
    <li class="active">Monitoring</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Monitoring</h2>
  </div>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
  @if(Session::has('status'))
            <h3 style="color: red">{{Session::get('status')}}</h3>
          @endif
    <form action="{{url('/saveMonitoring')}}" method="post">
    {{csrf_field()}}
  						<table class="table table-striped table-bordered table-condensed" >
  						    <thead>
  						    <tr>
                      <th>JUMLAH CLUSTERING</th>
                      <th>JUMLAH NULL/BLANK</th>
  						    </tr>
  						    </thead>
                  <tr>
                      <td>{{$clustering}}</td>
                      <td><a href="{{url('listNull')}}"> {{$null}} </a></td>
                      <input type="text" name="clustering" value="{{$clustering}}" hidden="">
                      <input type="text" name="null" value="{{$null}}" hidden="">
                  </tr>
  						</table>
              <br>
              <button type="submit" class="btn btn-sm btn-info pull-right" id="btnsave">Save Monitoring</button>
      </form>
  	</div>
</div><!--/.row-->

<hr>

<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
          <div class="panel-heading" align="center">History of Monitoring</div>
					<div class="panel-body">
						<table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
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
