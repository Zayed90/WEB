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
    ID Running: {{ $id_running }}
    Host Name: {{ $datasource_detail['host'] }}
    Database Name: {{ $datasource_detail['db_name'] }}
    User Name: {{ $datasource_detail['db_username'] }}
    Port: {{ $datasource_detail['port'] }}
  <b>  Table Source: {{ $datasource_detail['table'] }} </b>
  <b>  Column Source: {{ $datasource_detail['col'] }} </b>
  </pre>

  <hr>
  <div class="row">
    <div class="col-lg-12">

                  </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-body">
            <table data-toggle="table" data-show-refresh="true" data-search="true"   data-page-size="20" data-pagination="true">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                </tr>
              </thead>
              @foreach($results as $i=>$row)
              @if(($loop->first) && (!empty($_GET['done'])))
              <tr class="success">
                @else
                <tr>
                  @endif
                  <td>{{$row->id}}</td>
                  <td>{{$row->name}}</td>
                </tr>
                @endforeach
              </table>
            </div>
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
      url: 'http://localhost:8000/cleansing/dedup/update?id='+id+"&data="+input.value,
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
      url: 'http://localhost:8000/cleansing/dedup/status?id='+id+"&data="+input.value,
    });
  });
}

</script>
  <!--/.row-->
  @endsection
