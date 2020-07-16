@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/cleansing/clustering')}}">Clustering</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Clustering</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4>Result & Information</h4>

  <pre>

    tipe :  {{ $tipe }}
    Host Name : {{ $datasource_detail['host'] }}
    Database Name : {{ $datasource_detail['db_name'] }}
    User Name : {{ $datasource_detail['db_username'] }}
    Port : {{ $datasource_detail['port'] }}
    Table name : {{ $table }}
    Column Name : {{ $column }}

    > Value Information
    Fingerprint : Matched value
    Cleansed Value : Value to be processed into cleansing

  </pre>

  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          @if($results!=null)
          <table  class="table" data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true" data-sort-name="status" data-sort-order="desc">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name New</th>
                <th>Fingerprint</th>
                <th>Total Cluster</th>
                <th>Cleansed Data</th>
                <th data-field="status">Status</th>
              </tr>
            </thead>
            <form method="post">
              {{ csrf_field() }}
            @foreach($results as $i=>$row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->id}}</td>
                <td>{{$row->name_new}}</td>
                <td>{{$row->fingerprint}}</td>
                <td>{{$row->total}}</td>
                <td>
                <p id="p{{$i}}" onClick="editData(event,'{{$i}}','{{$row->id}}')">{{$row->cleansed_value}}</p>
                    <input id="p-input{{$i}}" style="display:none;" type="text" value={{$row->cleansed_value}}>
                </td>
                <td>
                    @if($row->status)
                    <p style="color:green;font-size:70%;text-align:center"  id="op{{$i}}" onClick="statusData(event,'{{$i}}','{{$row->id}}')">
                    <b>Data Cleansed</b></p>
                    <select id="op-input{{$i}}" style="display:none;" size="2">
                      <option style="color:green;font-size:70%" value="Data Cleansed"><b>Data Cleansed</b></option>
                      <option style="color:red;font-size:70%" value="Not Cleansed"><b>Not Cleansed</b></option>
                    </select>
                    @else
                    <p style="color:red;font-size:70%;text-align:center" id="op{{$i}}" onClick="statusData(event,'{{$i}}','{{$row->id}}')">
                      <b>Not Cleansed</b></p>
                      <select id="op-input{{$i}}" style="display:none;" size="2">
                        <option style="color:red;font-size:70%" value="Not Cleansed"<b>>Not Cleansed</b></option>
                        <option style="color:green;font-size:70%" value="Data Cleansed"><b>Data Cleansed</b></option>
                      </select>
                    @endif
                </td>
              </tr>
              @endforeach
            </table>
            @else
            <h3>No Data, make sure to Profiling this Column First</h3>
            @endif
            <hr/>

            <div>
            {{-- <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#bulk">Next to Bulk Process</button>
           --}}

          </div>
            <div class="col-xs-12 col-md-6 col-lg-6 collapse" id="bulk" style="margin-top: 10px">
              <div class="form-group">
                <label for="exampleInputEmail1">Column Filter</label>
                <input type="text" class="form-control" name="filter">
                <small class="form-text text-muted">Enter column filter to Exception in every fist line of code</small>
              </div>
            <input type="hidden" class="form-control" name="column" value="{{$column}}">
            <input type="hidden" class="form-control" name="table" value="{{$table}}">
            <input type="hidden" class="form-control" name="tipe_database" value="{{$tipe}}">
            <button formaction="{{ url('/cleansing/clustering/process') }}" type="submit" class="btn btn-primary btn-block" data-toggle="modal" data-target=".bd-example-modal-lg">Next</button>

        </div>


        {{-- <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top: 10px">
          <hr/>
        <!-- <button type="submit" formaction="{{url('/cleansing/pattern/manualProcess')}}" class="btn btn-info">Next Process per Pattern</button> -->
        </div> --}}
      </form>
      <form method="post" action="{{ url('/cleansing/clustering/manualProcess') }}">
        {{ csrf_field() }}
          <div class="row">
                <div class="col-md-3">
                    <div class="form-group" >
                        <small class="form-text text-muted">.</small>
                        <input type="hidden" class="form-control" name="table" value="{{$table}}">
                        <input type="hidden" class="form-control" name="column" value="{{$column}}">
                        <input type="hidden" class="form-control" name="tipe_database" value="{{$tipe}}">
                        <button class="btn btn-info btn-block">Next Process Clustering</button>
                    </div>
        </form>
        </div>



        </div>

        <a href="{{route('clustering_cleansing')}}"<button type="button" class="btn btn-success btn-block">Back</button></a>
      </div>
    </div>
  </div>

  <script>
  function editData(e,i,id) {
    e.currentTarget.style.display = 'none';
    var input = document.getElementById("p-input"+i);
    input.style.display = 'block';
    input.addEventListener("keypress", function(ev) {
      if ( ev.keyCode === 13) {

      input.style.display = 'none';
      var p = document.getElementById("p"+i);
      p.innerHTML = input.value;
      p.style.display = 'block';
      $.ajax({
        type: 'GET',
        url: 'http://localhost:8000/cleansing/clustering/update?id='+id+"&data="+input.value,
      });
      // alert(i);
      }
    });
  }

  function statusData(e,i,id) {
    e.currentTarget.style.display = 'none';
    var input = document.getElementById("op-input"+i);
    input.style.display = 'block';
    $(input).click(function(ev) {
      input.style.display = 'none';
      var p = document.getElementById("op"+i);
      p.innerHTML = input.value;
      p.style.display = 'block';
      $.ajax({
        type: 'GET',
        url: 'http://localhost:8000/cleansing/clustering/status?id='+id+"&data="+input.value,
      });
    });
  }

  </script>

  <!--/.row-->
  @endsection
