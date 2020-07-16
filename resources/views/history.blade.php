@extends('mdm_template.mdm_templat')
@section('contentMDM')
<div class="col-lg-12" style="margin-top: 20px">
    <div class="panel panel-default">
      <div class="panel-blue panel-body">
        <h3 style="color: white">Master Data History</h3>
      </div>
    </div>
  </div>

    <div class="tab-content">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="navbar-btn active" data-toggle="tab" href="#insert" role="tab" aria-controls="home">Insert</a>
            </li>
            <li class="navbar-btn nav-item">
                <a class="nav-link" data-toggle="tab" href="#upd" role="tab" aria-controls="profile">Update</a>
            </li>
        </ul>
        <div class="tab-pane active" id="insert" role="tabpanel">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="text">
                            <div class="card-header">
                            </div>
                            {{ csrf_field() }}
                            <div class="card-body">
                                <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                    <thead>
                                    <tr>
                                        <th data-sortable='true'>Running At</th>
                                        <th data-sortable='true'>Data Source</th>
                                        <th>Result</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataHs as $sh)
                                        <tr>
                                            <td>{{ $sh->created_at }}</td>
                                            <td>{{ $sh->source }}</td>

                                            <td>
                                                <a href="history/insert/{{$sh->created_at}}" ><button type="button" class="btn btn-sm btn-success" >See Result</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!--/.col-->
            </div>
        </div>
        <div class="tab-pane" id="upd" role="tabpanel">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="text">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                    <thead>

                                    <tr>
                                        <th data-sortable='true'>Running At</th>
                                        <th data-sortable='true'>Data Source</th>
                                        <th>Result</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataUp as $up)
                                        <tr>
                                            <td>{{ $up->created_at }}</td>
                                            <td>{{ $up->data_source }}</td>

                                            <td>
                                                <a href="history/update/{{$up->created_at}}" ><button type="button" class="btn btn-sm btn-success" >See Result</button></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!--/.col-->
            </div>
        </div>

    </div>
    </div>

@endsection()