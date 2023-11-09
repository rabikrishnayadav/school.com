@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Admin</h1>
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
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>First Name<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" name="name" value="{{ old('name', $getRecord->name) }}" required placeholder="First Name">
                      <div style="color:red;">{{ $errors->first('name') }}</div>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Last Name</label>
                      <input type="text" class="form-control" value="{{ old('last_name', $getRecord->last_name) }}" name="last_name" placeholder="Last Name">
                      <div style="color:red;">{{ $errors->first('last_name') }}</div>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Email<span style="color:red;">*</span></label>
                      <input type="email" class="form-control" name="email" value="{{ old('email', $getRecord->email) }}" required placeholder="Email">
                      <div style="color:red;">{{ $errors->first('email') }}</div>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Profile Picture<span style="color:red;"></span></label>
                      <input type="file" class="form-control" name="profile_pic">
                      <div style="color:red;">{{ $errors->first('profile_pic') }}</div>
                      @if(!empty($getRecord->getProfile()))
                        <img src="{{ $getRecord->getProfile() }}" style="width:auto; height:50px">
                      @endif
                    </div>

                    <div class="form-group col-md-6">
                      <label>Password</label>
                      <input type="text" class="form-control" name="password" placeholder="Password">
                      <p>Do you want to change password so please add new password</p>
                    </div>
                  </div>
                  
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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