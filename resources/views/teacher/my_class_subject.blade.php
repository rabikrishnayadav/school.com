@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>My Class & Subject</h1>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Class & Subject</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Class Name</th>
                      <th>Subject Name</th>
                      <th>Subject Type</th>
                      <th>Today Class Time <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( <span class="text-info">{{date('l')}}</span> )</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                      <tr>
                        <td>{{ $value->class_name }}</td>
                        <td>{{ $value->subject_name }}</td>
                        <td>{{ $value->subject_type }}</td>
                        <td>
                          @php
                          $ClassSubject = $value->getMyTimeTable($value->class_id, $value->subject_id);
                          @endphp
                          @if(!empty($ClassSubject))
                          {{ !empty($ClassSubject) ? date('h:i A', strtotime($ClassSubject->start_time)) : '' }}&nbsp;&nbsp; to &nbsp;&nbsp;
                          {{ !empty($ClassSubject) ? date('h:i A', strtotime($ClassSubject->end_time)) : '' }}
                          <br />
                          Room No: {{ $ClassSubject->room_number }}
                          @endif
                        </td>
                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                        <td>
                          <a href="{{ url('teacher/my_class_subject/class_timetable/'.$value->class_id.'/'.$value->subject_id) }}" class="btn btn-info btn-sm">Full Week Timetable</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                
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