@extends('mdm_template.mdm_templat')
@section('contentMDM')
<head>
    <style>

        .text {
            height: 450px;
            overflow-y: auto;
        }
    </style>
</head>
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-footer">
                        <a type="button" class="btn btn-sm btn-danger" name="back" id="back" href="{{ URL::previous() }}"><i class="fa fa-ban" ></i> Back</a>
                    </div>
                    <div class="text">
                        <div class="card-body">
                            <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                <thead>
                                <tr>
                                    <th colspan="5">App</th>
                                    <th colspan="4">Master</th>
                                </tr>

                                <tr>
                                    <th>id</th>
                                    <th>Company Name</th>
                                    <th>Address</th>
                                    {{-- <th>Sector ID</th> --}}
                                    <th>Source</th>
                                    <th>Company Name</th>
                                    <th>Address</th>
                                    {{-- <th>Sector ID</th> --}}
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Created At</th>


                                </tr>
                                </thead>
                                <tbody>
                                @foreach($hisUp as $hup)
                                    <tr>
                                        <th>{{ $hup->id }}</th>
                                        <td>{{ $hup->company_name }}</td>
                                        <td>{{ $hup->address }}</td>
                                        {{-- <td>{{ $hup->sector_id }}</td> --}}
                                        <td>{{ $hup->data_source }}</td>
                                        <td>{{ $hup->master_data_company_name }}</td>
                                        <td>{{ $hup->master_data_address }}</td>
                                        {{-- <td>{{ $hup->master_data_sector_id }}</td> --}}
                                        <td>{{ $hup->master_data_source }}</td>
                                        <td>{{ $hup->status }}</td>
                                        <td>{{ $hup->created_at }}</td>


                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()