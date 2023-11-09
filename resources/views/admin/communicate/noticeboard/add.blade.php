@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Notice Board</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="card-body">
                  
                  <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" required placeholder="Title">
                  </div>

                  <div class="row">
                    <div class="form-group col-md-3">
                    <label>Notice Date</label>
                    <input type="date" class="form-control" name="notice_date" required>
                  </div>

                  <div class="form-group col-md-3">
                    <label>Publish Date</label>
                    <input type="date" class="form-control" name="publish_date" required>
                  </div>
                  </div>

                  <div class="form-group">
                    <label style="display: block;">Message To</label>
                    <label style="margin-right: 50px;"><input type="checkbox" value="2" name="message_to[]">&nbsp; Teacher</label>
                    <label style="margin-right: 50px;"><input type="checkbox" value="3" name="message_to[]">&nbsp; Student</label>
                    <label style="margin-right: 50px;"><input type="checkbox" value="4" name="message_to[]">&nbsp; Parent</label>
                  </div>
                  
                  <div class="form-group">
                    <label>Message</label>
                    <textarea id="compose-textarea" class="form-control" name="message" style="height: 300px">
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
    });

  </script>

@endsection
