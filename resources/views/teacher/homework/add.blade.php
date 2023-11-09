@extends('layouts.app')

@section('style')
<style type="text/css">
  
</style>
@endsection
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Homework</h1>
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
            <div class="card card-primary">
              
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Class <span style="color: red;">*</span></label>
                      <select class="form-control" id="getClass" name="class_id" required>
                        <option value="">Select Class</option>
                        @foreach($getClass as $class)
                        <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Subject <span style="color: red;">*</span></label>
                      <select class="form-control" id="getSubject" name="subject_id" required>
                        <option value="">Select Subject</option>
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Homework Date <span style="color: red;">*</span></label>
                      <input type="date" name="homework_date" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Submission Date <span style="color: red;">*</span></label>
                      <input type="date" name="submission_date" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Document</label>
                      <input type="file" name="document_file" class="form-control">
                    </div>
                    
                  </div>

                  <div class="form-group">
                      <label>Description <span style="color: red;">*</span></label>
                      <textarea id="compose-textarea" class="form-control" name="description" style="height: 300px">
                      </textarea>
                    </div>
                  
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


@endsection

@section('script')

<script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script>

  <script type="text/javascript">

    $(function () {      

      $('#compose-textarea').summernote({
        height: 200
      });

      $('#getClass').change(function(){
        var class_id = $(this).val();
        $.ajax({
          type: "POST",
          url: "{{ url('teacher/ajax_get_subject') }}",
          data: {
            "_token": "{{ csrf_token() }}",
            class_id: class_id,
          },
          dataType: "json",
          success: function(data){
            $('#getSubject').html(data.success);
            // alert(data.message);
          }
        });
      });
    });

  </script>

@endsection
