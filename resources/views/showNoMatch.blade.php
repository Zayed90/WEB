@extends('mdm_template.mdm_templat')
@section('contentMDM')
<head>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
</head>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-blue panel-body" style="margin-top: 20px;">
              <h3 style="color: white">Master Data Input</h3>
            </div>
          </div>
        <div class="col-lg-12">
            <div class="card" >
                <div class="card-body">
                    {!! Form::open(['method'=>'get']) !!}
                    <div class="form-group row" style="margin-top: 10px">
                        <label class="col-md-1 col-form-label" for="select">Select</label>
                        <div class="col-md-3">
                            {!! Form::select('data_source',['-1'=>'Select Data Source','ereg'=>'ereg','asrot'=>'asrot','etrack_dn'=>'etrack_dn','etrack_ln'=>'etrack_ln'],null,['class'=>'form-control','onChange'=>'form.submit()']) !!}
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                            <span class="input-group-btn">
                                                 <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                            </span>
                                <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="">
                            </div>
                        </div>
                        <input type="hidden" value="{{request('field')}}" name="field"/>
                        <input type="hidden" value="{{request('sort')}}" name="sort"/>
                    </div>
    
                    {!! Form::close() !!}
                    <form action="{{url('insert_data')}}" method="post">
                        {{ csrf_field() }}
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
    
                        <div class="container">
                            <table class="table table-responsive-sm table-bordered table-striped table-sm" >
                                <thead>
                                <tr>
                                    <th colspan="3">App Data</th>
                                    <th colspan="3">Master Data</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Nama Perusahaan</th>
                                    <th>Alamat</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Alamat</th>
                                    <th>Master Data Source</th>
                                </tr>
                                </thead>
                                <tbody>
    
    
                                @foreach($customers as $cs)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check[]" id="check"
                                                   value="{{$cs->id}}"/>
                                        </td>
                                        <td>{{ $cs->company_name }}</td>
                                        <td>{{ $cs->address }}</td>
                                        <td>{{ $cs->master_data_company_name }}</td>
                                        <td>{{ $cs->master_data_address }}</td>
                                        <td>{{ $cs->master_data_source }}</td>
                                    </tr>
    
                                @endforeach

                                </tbody>
    
                            </table>
                        </div>
    
                        {{ $customers->links('vendor.pagination.bootstrap-4') }}

                       <div class="card-footer">
                           <button type="submit" class="btn btn-primary" name="submit" id="submit"><i
                                       class="fa fa-upload"></i>
                               Insert
                           </button>
    
                           <button type="submit" class="btn btn-danger" name="update" id="update"><i class="fa fa-history"></i> Update</button>
                       </div>
                    </form>
    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
