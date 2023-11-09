@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Admin List (Total : {{ $getRecord->total() }})</h1>
        </div>
        <div class="col-sm-6" style="text-align:right;">
          <a href="{{ url('admin/admin/add') }}" class="btn btn-primary">Add New Admin</a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">      
          <div class="col-md-12">
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card">
                <div class="card-header">
                <h3 class="card-title">Search Admin</h3>
                </div>
                <!-- form start -->
                <form method="get" action="">
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label>First Name</label>
                        <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name" placeholder="First Name">
                      </div>
                      <div class="form-group col-md-3">
                        <label>Last Name</label>
                        <input type="text" class="form-control" value="{{ Request::get('last_name') }}" name="last_name" placeholder="Last Name">
                      </div>
                      <div class="form-group col-md-3">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ Request::get('email') }}" name="email" placeholder="Email">
                      </div>
                      <div class="form-group col-md-3">
                        <label>Date</label>
                        <input type="date" class="form-control" value="{{ Request::get('date') }}" name="date" placeholder="Date">
                      </div>
                      <div class="form-group col-md-3">
                        <button class="btn btn-primary" style="margin-top: 30px;">Search</button>
                        <a href="{{ url('admin/admin/list') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                      </div>
                    </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
            @include('_message')
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admin List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Profile</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Created Date</th>
                      <th>Updated Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>
                          @if(!empty($value->getProfileDirect()))
                          <img src="{{ $value->getProfileDirect() }}" style="width:50px; height:50px; border-radius: 50px;">
                          @endif
                        </td>
                        <td>{{ $value->name }} {{ $value->last_name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                        <td>{{ date('d-m-Y H:i A', strtotime($value->updated_at)) }}</td>
                        <td style="min-width: 320px;">
                          <a href="{{ url('admin/admin/edit/'.$value->id) }}" class="btn btn-warning">Edit</a>&nbsp;
                          <a href="{{ url('admin/admin/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>&nbsp;
                          <a href="{{ url('chat?receiver_id='.base64_encode($value->id)) }}" class="btn btn-success">Send Message</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                  {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        <!-- /.col -->
      </div>
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection