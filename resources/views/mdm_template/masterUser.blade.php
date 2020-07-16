@extends('mdm_template.mdm_templat')
@section('contentMDM')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Master Data Table
                </div>
                <br>


                {!! Form::open(['method'=>'get']) !!}
                <div class="form-group row">

                    <label class="col-md-1 col-form-label" for="select" >Source</label>
                    <div class="col-md-3">
                        {!! Form::select('source',['-1'=>'Select Data Source','asrot'=>'asrot','ereg'=>'ereg','etrack_dn'=>'etrack dn','etrack_ln'=>'etrack ln'],null,['class'=>'form-control','onChange'=>'form.submit()']) !!}
                    </div>

                    <br>


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


                <div class="card-body">
                    <table class="table table-responsive-sm table-bordered table-striped table-sm">
                        <thead>

                        <tr>
                            <th>id</th>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Source</th>
                            <th>Created At</th>
                            <th>Update At</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($view as $v)
                            <tr>
                                <th>{{ $v->id }}</th>
                                <td>{{ $v->company_name }}</td>
                                <td>{{ $v->address }}</td>
                                <td>{{ $v->source }}</td>
                                <td>{{ $v->created_at }}</td>
                                <td>{{ $v->updated_at }}</td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $view->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
