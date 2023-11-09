@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Exam Result ( <b class="text-info">{{ $getStudent->name }} {{ $getStudent->last_name }}</b> )</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">      
          @foreach($getRecord as $value)
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ $value['exam_name'] }}</h3>
                <a class="btn btn-primary btn-sm float-right" target="_blank" href="{{ url('parent/my_exam_result/print?exam_id='.$value['exam_id'].'&student_id='.$getStudent->id) }}">Print</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Subject Name</th>
                      <th>Class Work</th>
                      <th>Home Work</th>                      
                      <th>Test Work</th>                      
                      <th>Exam</th>
                      <th>Total Score</th>
                      <th>Passing Mark</th> 
                      <th>Full Mark</th>                      
                      <th>Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $total_score = 0;
                      $full_mark = 0;
                      $result_validation = 0;
                    @endphp
                    @foreach($value['subject'] as $exam)
                      @php
                        $total_score = $total_score + $exam['total_score'];
                        $full_mark = $full_mark + $exam['full_mark'];
                      @endphp
                    <tr>
                      <td style="min-width: 250px;">{{ $exam['subject_name'] }}</td>
                      <td>{{ $exam['class_work'] }}</td>
                      <td>{{ $exam['home_work'] }}</td>
                      <td>{{ $exam['test_work'] }}</td>
                      <td>{{ $exam['exam'] }}</td>
                      <td>{{ $exam['total_score'] }}</td>
                      <td>{{ $exam['passing_mark'] }}</td>
                      <td>{{ $exam['full_mark'] }}</td>
                      <td>
                        @if($exam['total_score'] >= $exam['passing_mark'])
                          <span style="color: green; font-weight: bold;">Pass</span>
                        @else
                          @php
                            $result_validation = 1;
                          @endphp
                          <span style="color: red; font-weight: bold;">Fail</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                    <tr>
                      <td colspan="2"><b>Grand Total : {{ $total_score }}/{{ $full_mark }}</b></td>
                      @php
                        $percentage = ($total_score * 100) / $full_mark;

                        $getGrade = App\Models\MarksGradeModel::getGrade($percentage);

                      @endphp
                      <td colspan="2"><b>Percentage : {{ round($percentage, 2) }} %</b></td>
                      <td colspan="2"><b>Grade : {{ $getGrade }}</b>
                      <td colspan="3">
                        <b>Result : @if($result_validation == 0)
                                    <span style="color: green;">Pass</span>
                                    @else
                                    <span style="color: red;">Fail</span>
                                    @endif
                        </b>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          @endforeach
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection