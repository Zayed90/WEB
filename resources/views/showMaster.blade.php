@extends('mdm_template.mdm_templat')
@section('contentMDM')

<div class="bs-callout bs-callout-success" style="margin-top: 20px;">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel panel-heading" style="background: #30a5ff">
                    <h3  style="margin-top: 10px; color: white">Master Data</h3>
                  </div>
                <div class="panel panel-body " >
                    {!! Form::open(['method'=>'get']) !!}
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-7">
                        <div class="input-group">
                                        <span class="input-group-btn">
                                             <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                        </span>
                            <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="">
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <table class="table table-responsive-sm table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Data Source</th>
                            <th>Used By</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                        </thead>
                        @foreach($sId as $v)

                             <tr>
                                <td>{{$v->id}}</td>
                                 <td>{{ $v->company_name }}</td>
                                 <td>{{ $v->address }}</td>
                                 <td>{{ $v->source }}</td>
                                 <td>
                                     <a href="viewMeta/{{$v->id}}" ><button type="button" class="btn btn-sm btn-success" >See Details</button></a>
                                 </td>
                                 <td>{{ $v->created_at }}</td>
                                 <td>{{ $v->updated_at }}</td>
                             </tr>
                             @endforeach
                    </table>
                </div>
                {{ $sId->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@endsection