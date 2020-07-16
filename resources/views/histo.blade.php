@extends('mdm_template.mdm_templat')
@section('contentMDM')
<div class="row" >
    <div class="col-sm-10" style="margin-top: 20px; margin-bottom: 20px">
<a type="button" class="btn btn-primary" name="back" id="back" href="{{ URL::previous() }}"><i class="fa fa-ban" ></i> Back</a>
    </div>
<div class="bs-callout bs-callout-success">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body" >
                    <h3>Table List Data Reference</h3>
                    <table data-toggle="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th data-sortable="true">Source</th>
                            <th data-sortable="true">Created At</th>
                        </tr>
                        </thead>
                        @foreach($hisIns as $his)
                                    <tr>
                                        <th>{{ $his->id }}</th>
                                        <td>{{ $his->company_name }}</td>
                                        <td>{{ $his->address }}</td>
                                        <td>{{ $his->source }}</td>
                                        <td>{{ $his->created_at }}</td>


                                    </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()