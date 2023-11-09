@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div>
          <h1>My Students</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">      
          <div class="col-md-12">
            
            @include('_message')
            
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Students</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Profile</th>
                      <th>Student Name</th>
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
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                      <tr>
                        <td>
                          @if(!empty($value->getProfile()))
                          <img src="{{ $value->getProfile() }}" style="width:50px; height:50px; border-radius: 50px;">
                          @endif
                        </td>
                        <td style="min-width: 150px;">{{ $value->name }} {{ $value->last_name }}</td>
                        
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
                        <td style="min-width: 200px;">{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                        <td style="min-width:300px;">
                          <a style="margin-bottom:10px;" href="{{ url('parent/my_student/attendance/'.$value->id) }}" class="btn btn-secondary btn-sm">Attendance</a>
                          <a style="margin-bottom:10px;" href="{{ url('parent/my_student/subject/'.$value->id) }}" class="btn btn-secondary btn-sm">Subjects</a>
                          <a style="margin-bottom:10px;" href="{{ url('parent/my_student/calendar/'.$value->id) }}" class="btn btn-secondary btn-sm">Calendar</a>
                          <a style="margin-bottom:10px;" href="{{ url('parent/my_student/homework/'.$value->id) }}" class="btn btn-warning btn-sm">Homework</a>
                          <a style="margin-bottom:10px;" href="{{ url('parent/my_student/submitted_homework/'.$value->id) }}" class="btn btn-success btn-sm">Submitted Homework</a>
                          <a style="margin-bottom:10px;" href="{{ url('parent/my_student/exam_timetable/'.$value->id) }}" class="btn btn-warning btn-sm">Exams</a>
                          <a style="margin-bottom:10px;" href="{{ url('parent/my_student/exam_result/'.$value->id) }}" class="btn btn-success btn-sm">Result</a>
                          <a style="margin-bottom:10px;" href="{{ url('parent/my_student/fees_collection/'.$value->id) }}" class="btn btn-primary btn-sm">Fees Collection</a>
                          <a style="margin-bottom:10px;" href="{{ url('chat?receiver_id='.base64_encode($value->id)) }}" class="btn btn-success btn-sm">Send Message</a>

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