@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/pattern')}}">Pattern</a></li>
    <li class="active">View</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View Pattern</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4>Result & Information</h4>

  <pre>
    ID Running : {{ $id_running }}
    Host Name : {{ $datasource_detail['host'] }}
    Database Name : {{ $datasource_detail['db_name'] }}
    User Name : {{ $datasource_detail['db_username'] }}
    Port : {{ $datasource_detail['port'] }}
    Table name : {{ $datasource_detail['tab'] }}
    Column Name : {{ $datasource_detail['col'] }}
  </pre>

  <hr>
  <div class="row">
    <div class="col-lg-12">
        <form method="post" action="{{ url('/cleansing/pattern/manualProcessSub') }}">
          {{ csrf_field() }}
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
              <div class="form-group">
                <label>Pattern</label>
                <select class="form-control" name="pattern" id="selectDB" onclick="selectDatabase()">
                    @foreach($pattern as $i=>$p)
                  <option value={{$p->NOMOR_PATTERN_BARU}}>{{$p->NOMOR_PATTERN_BARU}}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted" id="small">Settings Database Connection <a href="{{ url('/database') }}">Here</a></small>
              
              </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">String to Clean</label>
                    <input type="text" class="form-control" name="old_string">
                  <input type="hidden" class="form-control" name="id_running" value="{{$id_running}}">
                    <small class="form-text text-muted">Enter table name to be used in this process.</small>
                  </div>
                  </div> 
                  <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">New Pattern</label>
                        <input type="text" class="form-control" name="new_string">
                        <small class="form-text text-muted">Enter table name to be used in this process.</small>
                        
                      </div>
                      <input type="checkbox" name="cleansed" value="cleansed"> Accept This to Cleansed String<br>
                  </div>  
                  <div class="col-md-2">
                      <div class="form-group" style="margin-top: 8px">
                          <small class="form-text text-muted">.</small>
                          
                          <button class="btn btn-success btn-block">Next</button>
                      </div>
                    </form>
                  </div>
        </div>

      <div class="panel panel-default">     
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>Data Not Cleansed</th>
                <th>Pattern</th>
                <th>Data Cleansed</th>
                <th>Status</th>
              </tr>
            </thead>
            @foreach($results as $i=>$row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->NOMOR_NIE}}</td>
              <td>{{$row->NOMOR_PATTERN_BARU}}</td>
                <td>
                <p id="p{{$i}}" onClick="editData(event,'{{$i}}','{{$row->id}}')">{{$row->nomor_cleansed}}</p>
                    <input id="p-input{{$i}}" style="display:none;" type="text" value={{$row->nomor_cleansed}}>
                </td>
                <td>
                    @if($row->status)
                    <p id="op{{$i}}" onClick="statusData(event,'{{$i}}','{{$row->id}}')">
                    Data Cleansed</p>
                    <select id="op-input{{$i}}" style="display:none;" size="2">
                      <option value="Data Cleansed">Data Cleansed</option>
                      <option value="Not Cleansed">Not Cleansed</option>
                    </select>
                    @else
                    <p id="op{{$i}}" onClick="statusData(event,'{{$i}}','{{$row->id}}')">
                      Not Cleansed</p>
                      <select id="op-input{{$i}}" style="display:none;" size="2">
                        <option value="Not Cleansed">Not Cleansed</option>
                        <option value="Data Cleansed">Data Cleansed</option>
                      </select>
                    @endif
                </td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
        <a href="{{route('pattern_cleansing')}}"<button type="button" class="btn btn-success btn-block">Back</button></a>
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
      url: 'http://localhost:8000/cleansing/pattern/update?id='+id+"&data="+input.value,
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
      url: 'http://localhost:8000/cleansing/pattern/status?id='+id+"&data="+input.value,
    });
  });
}

</script>
  <!--/.row-->
  @endsection
