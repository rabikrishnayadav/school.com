@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>My Attendance (Total: <span class="text-info"> {{ $getRecord->total() }} </span> )</h1>
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
                <h3 class="card-title">Search My Attendance</h3>
                </div>
                <!-- form start -->
                <form method="get" action="">
                  <div class="card-body">
                    <div class="row">
                   
                      <div class="form-group col-md-2">
                        <label>Class</label>
                        <select class="form-control" name="class_id">
                          <option value="">Select</option>
                          @foreach($getClass as $class)
                          <option {{ (Request::get('class_id') == $class->class_id) ? 'selected' : '' }} value="{{ $class->class_id }}">{{ $class->class_name }}</option>
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

                      <div class="form-group col-md-2">
                        <button class="btn btn-primary" style="margin-top: 30px;">Search</button>
                        <a href="{{ url('student/my_attendance') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                      </div>
                    </div>
                </form>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Attendance</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Class Name</th>
                      <th>Attendance</th>
                      <th>Attendance Date</th>
                      <th>Created Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($getRecord as $value)
                      <tr>
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
                          <td>{{ date('d-m-Y', strtotime($value->attendance_date)) }}</td>
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                      </tr>
                    @empty
                      <td colspan="100%">Record not found</td>
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