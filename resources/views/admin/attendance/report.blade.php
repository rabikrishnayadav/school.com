@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Student Attendance Report (Total: <span class="text-info"> {{ $getRecord->total() }} </span> )</h1>
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
                <h3 class="card-title">Search Student Attendance Report</h3>
                </div>
                <!-- form start -->
                <form method="get" action="">
                  <div class="card-body">
                    <div class="row">
                      
                      <div class="form-group col-md-2">
                        <label>Student ID</label>
                        <input type="text" name="student_id" value="{{ Request::get('student_id') }}" class="form-control" placeholder="Student ID">
                      </div>

                      <div class="form-group col-md-2">
                        <label>Student Name</label>
                        <input type="text" name="student_name" value="{{ Request::get('student_name') }}" class="form-control" placeholder="Student Name">
                      </div>

                      <div class="form-group col-md-2">
                        <label>Student Last Name</label>
                        <input type="text" name="student_last_name" value="{{ Request::get('student_last_name') }}" class="form-control" placeholder="Student Last Name">
                      </div>

                      <div class="form-group col-md-2">
                        <label>Class</label>
                        <select class="form-control" name="class_id">
                          <option value="">Select</option>
                          @foreach($getClass as $class)
                          <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="form-group col-md-2">
                        <label>Attendance Type</label>
                        <select class="form-control" name="attendance_type">
                          <option value="">Select</option>
                          <option {{ (Request::get('attendance_type') == 1) ? 'selected' : '' }} value="1">Present</option>
                          <option {{ (Request::get('attendance_type') == 2) ? 'selected' : '' }} value="2">Absent</option>
                          <option {{ (Request::get('attendance_type') == 3) ? 'selected' : '' }} value="3">Late</option>
                          <option {{ (Request::get('attendance_type') == 4) ? 'selected' : '' }} value="4">Half Day</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3">
                        <label>Start Attendance Date</label>
                        <input type="date" name="start_attendance_date" value="{{ Request::get('start_attendance_date') }}" class="form-control">
                      </div>

                      <div class="form-group col-md-3">
                        <label>End Attendance Date</label>
                        <input type="date" name="end_attendance_date" value="{{ Request::get('end_attendance_date') }}" class="form-control">
                      </div>

                      <div class="form-group col-md-3">
                        <button class="btn btn-primary" style="margin-top: 30px;">Search</button>
                        <a href="{{ url('admin/attendance/report') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                      </div>
                    </div>
                </form>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Student Attendance List</h3>
                <form method="post" style="float: right;" action="{{ url('admin/attendance/report_export_excel') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="student_id" value="{{ Request::get('student_id') }}">
                    <input type="hidden" name="student_name" value="{{ Request::get('student_name') }}">
                    <input type="hidden" name="student_last_name" value="{{ Request::get('student_last_name') }}">
                    <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                    <input type="hidden" name="start_attendance_date" value="{{ Request::get('start_attendance_date') }}">
                    <input type="hidden" name="end_attendance_date" value="{{ Request::get('end_attendance_date') }}">
                    <input type="hidden" name="attendance_type" value="{{ Request::get('attendance_type') }}">
                    <button type="submit" class="btn btn-primary">Export Excel</button>
                  </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Student Name</th>
                      <th>Class Name</th>
                      <th>Attendance</th>
                      <th>Taken By</th>
                      <th>Attendance Date</th>
                      <th>Created Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($getRecord as $value)
                      <tr>
                        <td>{{ $value->student_id }}</td>
                        <td>{{ $value->student_name }} {{ $value->student_last_name }}</td>
                        <td>{{ $value->class_name }}</td>
                        <td>
                          @if($value->attendance_type == 1)
                            Present
                          @elseif($value->attendance_type == 2)
                            Absent
                          @elseif($value->attendance_type == 3)
                            Late
                          @elseif($value->attendance_type == 4)
                            Half Day
                          @endif
                        </td>
                        <td>{{ $value->created_name }}</td>
                        <td>{{ date('d-m-Y', strtotime($value->attendance_date)) }}</td>
                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                      </tr>
                      @empty
                        <tr>
                          <td colspan="100%">Record not found</td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                  {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
      </div>      
    </div>
  </section>
</div>


@endsection


@section('script')

<script type="text/javascript">

  
</script>

@endsection