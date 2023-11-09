@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Mark Grade</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              
              <!-- form start -->
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Grade Name</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" required placeholder="Grade Name">
                  </div>
                  <div class="form-group">
                    <label>Percent From</label>
                    <input type="number" class="form-control" value="{{ old('percent_from') }}" name="percent_from" required placeholder="Percent From">
                  </div>
                  <div class="form-group">
                    <label>Percent To</label>
                    <input type="number" class="form-control" value="{{ old('percent_to') }}" name="percent_to" required placeholder="Percent To">
                  </div>                  
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


@endsection