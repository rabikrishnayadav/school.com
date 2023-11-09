@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div>
          <h1>Parent Students List (<b>{{ $getParent->name }} {{ $getParent->last_name }}</b>)</h1>
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
                <h3 class="card-title">Search Student</h3>
                </div>
                <!-- form start -->
                <form method="get" action="">
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label>Student ID</label>
                        <input type="text" class="form-control" value="{{ Request::get('id') }}" name="id" placeholder="Student ID">
                      </div>
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
                        <label>Mobile Number</label>
                        <input type="text" class="form-control" value="{{ Request::get('mobile_number') }}" name="mobile_number" placeholder="Mobile Number">
                      </div>
                      
                      <div class="form-group col-md-3">
                        <button class="btn btn-primary" style="margin-top: 30px;">Search</button>
                        <a href="{{ url('admin/parent/my-student/'.$parent_id) }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                      </div>
                    </div>                    
                    </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
            @include('_message')
            @if(!empty($getSearchStudent))
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Student List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Profile</th>
                      <th>Studnet Name</th>
                      <th>Email</th>
                      <th>Mobile Number</th>
                      <th>Gender</th>
                      <th>Parent Name</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getSearchStudent as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>
                          @if(!empty($value->getProfile()))
                          <img src="{{ $value->getProfile() }}" style="width:50px; height:50px; border-radius: 50px;">
                          @endif
                        </td>
                        <td style="min-width: 150px;">{{ $value->name }} {{ $value->last_name }}</td>
                        <td>{{ $value->email }}</td>
                        <td style="min-width: 150px;">{{ $value->mobile_number }}</td>
                        <td>{{ $value->gender }}</td>
                        <td>{{ $value->parent_name }}</td>                        
                        <td style="min-width: 200px;">{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                        <td style="min-width: 200px;">
                          <a href="{{ url('admin/parent/assign_student_parent/'.$value->id).'/'.$parent_id }}" class="btn btn-info">Add to Parent</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                  
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            @endif
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Parent Student List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Profile</th>
                      <th>Studnet Name</th>
                      <th>Email</th>
                      <th>Mobile Number</th>
                      <th>Gender</th>
                      <th>Parent Name</th>
                      <th>Created Date</th>
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
                        <td style="min-width: 150px;">{{ $value->name }} {{ $value->last_name }}</td>
                        <td>{{ $value->email }}</td>
                        <td style="min-width: 150px;">{{ $value->mobile_number }}</td>
                        <td>{{ $value->gender }}</td>
                        <td>{{ $value->parent_name }}</td>                        
                        <td style="min-width: 200px;">{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                        <td style="min-width: 200px;">
                          <a href="{{ url('admin/parent/assign_student_parent_delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                  
                </div>
              </div>
              <!-- /.card-body -->
            </div>

          </div>
        <!-- /.col -->
      </div>
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection