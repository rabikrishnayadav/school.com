@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Student List (Total : {{ $getRecord->total() }})</h1>
        </div>
        <div class="col-sm-6" style="text-align:right;">
          <a href="{{ url('admin/student/add') }}" class="btn btn-primary">Add New Student</a>
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
                        <label>Admission Number</label>
                        <input type="text" class="form-control" value="{{ Request::get('admission_number') }}" name="admission_number" placeholder="Admission Number">
                      </div>
                      <div class="form-group col-md-3">
                        <label>Roll Number</label>
                        <input type="text" class="form-control" value="{{ Request::get('roll_number') }}" name="roll_number" placeholder="Roll Number">
                      </div>

                      <div class="form-group col-md-3">
                        <label>Class</label>
                        <input type="text" class="form-control" value="{{ Request::get('class') }}" name="class" placeholder="Class">
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
                        <label>Caste</label>
                        <input type="text" class="form-control" value="{{ Request::get('caste') }}" name="caste" placeholder="Caste">
                      </div>

                      <div class="form-group col-md-3">
                        <label>Religion</label>
                        <input type="text" class="form-control" value="{{ Request::get('religion') }}" name="religion" placeholder="Religion">
                      </div>

                      <div class="form-group col-md-3">
                        <label>Blood Group</label>
                        <input type="text" class="form-control" value="{{ Request::get('blood_group') }}" name="blood_group" placeholder="Blood Group">
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
                        <label>Admission Date</label>
                        <input type="date" class="form-control" value="{{ Request::get('admission_date') }}" name="admission_date">
                      </div>

                      <div class="form-group col-md-3">
                        <label>Created Date</label>
                        <input type="date" class="form-control" value="{{ Request::get('date') }}" name="date" placeholder="Date">
                      </div>
                      <div class="form-group col-md-3">
                        <button class="btn btn-primary" style="margin-top: 30px;">Search</button>
                        <a href="{{ url('admin/student/list') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                      </div>
                    </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
            @include('_message')
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-2">
                    <h3 class="card-title">Student List</h3>
                  </div>
                  <div class="col-md-6" class="form-group">
                    <div class="row">
                      <div class="p-1">Show </div>
                      <div>
                        <select name="show_entry" class="form-control getEntry" style="max-width: 50px;">
                          <option value="10">10</option>
                          <option value="25">25</option>
                          <option value="50">50</option>
                          <option value="100">100</option>
                        </select>
                      </div>
                      <div class="p-1"> Entry</div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <a href="{{ url('admin/student/export_pdf') }}" class="btn btn-warning">Download Pdf</a>
                  </div>
                  <div class="col-md-2">
                    <form method="post" action="{{ url('admin/student/export_excel') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="name" value="{{ Request::get('name') }}">
                    <input type="hidden" name="last_name" value="{{ Request::get('last_name') }}">
                    <input type="hidden" name="email" value="{{ Request::get('email') }}">
                    <input type="hidden" name="admission_number" value="{{ Request::get('admission_number') }}">
                    <input type="hidden" name="roll_number" value="{{ Request::get('roll_number') }}">
                    <input type="hidden" name="gender" value="{{ Request::get('gender') }}">
                    <input type="hidden" name="class" value="{{ Request::get('class') }}">
                    <input type="hidden" name="caste" value="{{ Request::get('caste') }}">
                    <input type="hidden" name="religion" value="{{ Request::get('religion') }}">
                    <input type="hidden" name="mobile_number" value="{{ Request::get('mobile_number') }}">
                    <input type="hidden" name="blood_group" value="{{ Request::get('blood_group') }}">
                    <input type="hidden" name="status" value="{{ Request::get('status') }}">
                    <input type="hidden" name="admission_date" value="{{ Request::get('admission_date') }}">
                    <input type="hidden" name="date" value="{{ Request::get('date') }}">

                    <button type="submit" class="btn btn-primary">Export Excel</button>
                  </form>
                  </div>
                </div>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Profile</th>
                      <th>Student Name</th>
                      <th>Parent Name</th>
                      <th>Email</th>
                      <th>Admission Number</th>
                      <th>Roll Number</th>
                      <th>Class</th>
                      <th>Gender</th>
                      <th>Date of Birth</th>
                      <th>Caste</th>
                      <th>Religion</th>
                      <th>Mobile Number</th>
                      <th>Admission Date</th>
                      <th>Blood Group</th>
                      <th>Height</th>
                      <th>Weight</th>
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
                        <td style="min-width: 150px;">{{ $value->parent_name }} {{ $value->parent_last_name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->admission_number }}</td>
                        <td>{{ $value->roll_number }}</td>
                        <td>{{ $value->class_name }}</td>
                        <td>{{ $value->gender }}</td>
                        <td style="min-width: 100px;">
                          @if(!empty($value->date_of_birth))
                          {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                          @endif
                        </td>
                        <td>{{ $value->caste }}</td>
                        <td>{{ $value->religion }}</td>
                        <td style="min-width: 150px;">{{ $value->mobile_number }}</td>
                        <td style="min-width: 100px;">
                          @if(!empty($value->admission_date))
                          {{ date('d-m-Y', strtotime($value->admission_date)) }}
                          @endif
                        </td>
                        <td>{{ $value->blood_group }}</td>
                        <td>{{ $value->height }}</td>
                        <td>{{ $value->weight }}</td>
                        <td>{{ ($value->status == 0) ? 'Active' : 'Inactive' }}</td>
                        <td style="min-width: 200px;">{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                        <td style="min-width: 200px;">{{ $value->updated_at }}</td>
                        <td style="min-width: 320px;">
                          <a href="{{ url('admin/student/edit/'.$value->id) }}" class="btn btn-warning">Edit</a>&nbsp;
                          <a href="{{ url('admin/student/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>&nbsp;
                          <a href="{{ url('chat?receiver_id='.base64_encode($value->id)) }}" class="btn btn-success">Send Message</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                
              </div>
              <!-- /.card-body -->
            </div>
            <div >
                  {{$getRecord->links('pagination::bootstrap-5')}}
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

@section('script')

<script type="text/javascript">
  $('.getEntry').change(function() {
    var show_entry = $(this).val();
    // $.ajax({
    //   url: "{{ url('admin/student/get_entry') }}",
    //   type: "POST",
    //   data: {
    //     "_token": "{{ csrf_token() }}",
    //     show_entry:show_entry,
    //   },
    //   dataType:"json",
    //   success:function(response){
    //     $('.getSubject').html(response.html);
    //   },
    // });
    alert(show_entry);
  });
</script>

@endsection