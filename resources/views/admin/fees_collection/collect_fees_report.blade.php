@extends('layouts.app')

@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-8">
          <h1>Collect Fees Report</h1>
        </div>
      </div>
    </div>
  </section>


  <section class="content">
    <div class="container-fluid">
      <div class="row">      
        <div class="col-md-12">

          <div class="col-md-12">
          <!-- general form elements -->
            <div class="card">
              <div class="card-header">
              <h3 class="card-title">Search Student Collected Fees Report</h3>
              </div>
              <!-- form start -->
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    
                    <div class="form-group col-md-2">
                      <label>Student ID</label>
                      <input type="text" name="student_id" value="{{ Request::get('student_id') }}" class="form-control" placeholder="Student ID">
                    </div>

                    <div class="form-group col-md-3">
                      <label>Student First Name</label>
                      <input type="text" name="student_name" value="{{ Request::get('student_name') }}" class="form-control" placeholder="Student First Name">
                    </div>

                    <div class="form-group col-md-3">
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
                      <label>Payment Type</label>
                      <select class="form-control" name="payment_type">
                        <option value="">Select</option>
                        <option {{ (Request::get('payment_type') == 'Cash') ? 'selected' : '' }} value="Cash">Cash</option>
                        <option {{ (Request::get('payment_type') == 'Cheque') ? 'selected' : '' }} value="Cheque">Cheque</option>
                        <option {{ (Request::get('payment_type') == 'Paypal') ? 'selected' : '' }} value="Paypal">Paypal</option>
                        <option {{ (Request::get('payment_type') == 'Stripe') ? 'selected' : '' }} value="Stripe">Stripe</option>
                        <option {{ (Request::get('payment_type') == 'Esewa') ? 'selected' : '' }} value="Esewa">Esewa</option>
                        <option {{ (Request::get('payment_type') == 'Khalti') ? 'selected' : '' }} value="Khalti">Khalti</option>
                      </select>
                    </div>

                    <div class="form-group col-md-3">
                      <label>Payment Made By</label>
                      <select class="form-control" name="user_type">
                        <option value="">Select</option>
                        <option {{ (Request::get('user_type') == '1') ? 'selected' : '' }} value="1">Admin</option>
                        <option {{ (Request::get('user_type') == '3') ? 'selected' : '' }} value="3">Student</option>
                        <option {{ (Request::get('user_type') == '4') ? 'selected' : '' }} value="4">Parent</option>
                      </select>
                    </div>

                    <div class="form-group col-md-3">
                      <label>Start Created Date</label>
                      <input type="date" name="start_created_date" value="{{ Request::get('start_created_date') }}" class="form-control">
                    </div>

                    <div class="form-group col-md-3">
                      <label>End Created Date</label>
                      <input type="date" name="end_created_date" value="{{ Request::get('end_created_date') }}" class="form-control">
                    </div>

                    <div class="form-group col-md-3">
                      <button class="btn btn-primary" style="margin-top: 30px;">Search</button>
                      <a href="{{ url('admin/fees_collection/collect_fees_report') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                    </div>
                  </div>
              </form>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-9">
                  <h3 class="card-title">Collect Fees Report</h3>
                </div>
                <div class="col-md-1">
                  <select class="form-control" name="pagination">
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="">All</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <form method="post" action="{{ url('admin/fees_collection/export_collect_fees_report') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="student_id" value="{{ Request::get('student_id') }}">
                    <input type="hidden" name="student_name" value="{{ Request::get('student_name') }}">
                    <input type="hidden" name="student_last_name" value="{{ Request::get('student_last_name') }}">
                    <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                    <input type="hidden" name="payment_type" value="{{ Request::get('payment_type') }}">
                    <input type="hidden" name="start_created_date" value="{{ Request::get('start_created_date') }}">
                    <input type="hidden" name="end_created_date" value="{{ Request::get('end_created_date') }}">
                    <button type="submit" class="btn btn-primary">Export Excel</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="card-body p-0" style="overflow:auto;">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Class Name</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Remaning Amount</th>
                    <th>Payment Type</th>
                    <th>Remark</th>
                    <th>Created By</th>
                    <th>Created Date</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($getRecord as $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td>{{ $value->student_id }}</td>
                      <td style="min-width:200px;">{{ $value->student_name_first }} {{ $value->student_name_last }}</td>
                      <td>{{ $value->class_name }}</td>
                      <td style="min-width:130px;">Rs. {{ number_format($value->total_amount, 2) }} /-</td>
                      <td style="min-width:130px;">Rs. {{ number_format($value->paid_amount, 2) }} /-</td>
                      <td style="min-width:130px;">Rs. {{ number_format($value->remaning_amount, 2) }} /-</td>
                      <td>{{ $value->payment_type }}</td>
                      <td>{{ $value->remark }}</td>
                      <td>{{ $value->created_name }}</td>
                      <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="100%">Record Not Found.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
              <div style="padding: 10px; float: right;">
                {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

</div>


@endsection

@section('script')



@endsection
