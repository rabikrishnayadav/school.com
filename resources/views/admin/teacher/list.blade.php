@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Teacher List (Total : {{ $getRecord->total() }})</h1>
        </div>
        <div class="col-sm-6" style="text-align:right;">
          <a href="{{ url('admin/teacher/add') }}" class="btn btn-primary">Add New Teacher</a>
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
                <h3 class="card-title">Search Teacher</h3>
                </div>
                <!-- form start -->
                <form method="get" action="">
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name" placeholder="Name">
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
                        <label>Gender</label>
                        <select class="form-control" name="gender">
                          <option value="">Select Gender</option>
                          <option {{ (Request::get('gender') == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                          <option {{ (Request::get('gender') == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                          <option {{ (Request::get('gender') == 'Other') ? 'selected' : '' }} value="Other">Other</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3">
                        <label>Marital Status</label>
                        <input type="text" class="form-control" value="{{ Request::get('marital_status') }}" name="marital_status" placeholder="Marital Status">
                      </div>
                      <div class="form-group col-md-3">
                        <label>Current Address</label>
                        <input type="text" class="form-control" value="{{ Request::get('address') }}" name="address" placeholder="Current Address">
                      </div>

                      <div class="form-group col-md-3">
                        <label>Status</label>
                        <select class="form-control" name="status">
                          <option value="">Select Status</option>
                          <option {{ (Request::get('status') == '100') ? 'selected' : '' }} value="100">Active</option>
                          <option {{ (Request::get('status') == '1') ? 'selected' : '' }} value="1">Inactive</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3">
                        <label>Date Of Joining</label>
                        <input type="date" class="form-control" value="{{ Request::get('admission_date') }}" name="admission_date">
                      </div>

                      <div class="form-group col-md-3">
                        <label>Created Date</label>
                        <input type="date" class="form-control" value="{{ Request::get('date') }}" name="date" placeholder="Date">
                      </div>
                      <div class="form-group col-md-3">
                        <button class="btn btn-primary" style="margin-top: 30px;">Search</button>
                        <a href="{{ url('admin/teacher/list') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                      </div>
                    </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
            @include('_message')
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Teacher List</h3>
                <form method="post" style="float: right;" action="{{ url('admin/teacher/export_excel') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="name" value="{{ Request::get('name') }}">
                    <input type="hidden" name="last_name" value="{{ Request::get('last_name') }}">
                    <input type="hidden" name="email" value="{{ Request::get('email') }}">
                    <input type="hidden" name="gender" value="{{ Request::get('gender') }}">
                    <input type="hidden" name="mobile_number" value="{{ Request::get('mobile_number') }}">
                    <input type="hidden" name="marital_status" value="{{ Request::get('marital_status') }}">
                    <input type="hidden" name="address" value="{{ Request::get('address') }}">
                    <input type="hidden" name="status" value="{{ Request::get('status') }}">
                    <input type="hidden" name="admission_date" value="{{ Request::get('admission_date') }}">
                    <input type="hidden" name="date" value="{{ Request::get('date') }}">

                    <button type="submit" class="btn btn-primary">Export Excel</button>
                  </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Profile</th>
                      <th>Teacher Name</th>
                      <th>Email</th>
                      <th>Gender</th>
                      <th>Date of Birth</th>
                      <th>Date Of Joining</th>
                      <th>Mobile Number</th>
                      <th>Matital Status</th>
                      <th>Current Address</th>
                      <th>Permanent Address</th>
                      <th>Qualification</th>
                      <th>Work Experience</th>
                      <th>Note</th>
                      <th>Status</th>
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
                        <td style="min-width: 150px;">{{ $value->name }} {{ $value->last_name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->gender }}</td>
                        <td style="min-width: 100px;">
                          @if(!empty($value->date_of_birth))
                          {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                          @endif
                        </td>
                        <td style="min-width: 100px;">
                          @if(!empty($value->admission_date))
                          {{ date('d-m-Y', strtotime($value->admission_date)) }}
                          @endif
                        </td>
                        <td style="min-width: 150px;">{{ $value->mobile_number }}</td>
                        <td>{{ $value->marital_status }}</td>
                        <td>{{ $value->address }}</td>
                        <td>{{ $value->permanent_address }}</td>
                        <td>{{ $value->qualification }}</td>
                        <td>{{ $value->work_experience }}</td>
                        <td>{{ $value->note }}</td>
                        <td>{{ ($value->status == 0) ? 'Active' : 'Inactive' }}</td>
                                                
                        <td style="min-width: 200px;">{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                        <td style="min-width: 200px;">{{ date('d-m-Y H:i A', strtotime($value->updated_at)) }}</td>
                        <td style="min-width: 320px;">
                          <a href="{{ url('admin/teacher/edit/'.$value->id) }}" class="btn btn-warning">Edit</a>&nbsp;
                          <a href="{{ url('admin/teacher/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>&nbsp;
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