@extends('layouts.app')

@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Setting</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            @include('_message')
            <div class="card card-light">
              <div class="card-header">
                <h3 class="card-title">Payment Settings</h3>
                </div>
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="row">
                    
                    <div class="form-group col-md-6">
                      <label>Paypal Public Key</label>
                      <input type="text" class="form-control" name="paypal_public_key" value="{{ $getRecord->paypal_public_key }}" placeholder="Paypal Public Key">
                    </div> 

                    <div class="form-group col-md-6">
                      <label>Paypal Secret Key</label>
                      <input type="text" class="form-control" name="paypal_secret_key" value="{{ $getRecord->paypal_secret_key }}" placeholder="Paypal Private Key">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Paypal Business Email</label>
                      <input type="email" class="form-control" name="paypal_email" value="{{ $getRecord->paypal_email }}" required placeholder="Paypal Business Email">
                    </div> 

                    <div class="form-group col-md-6">
                      <label>Paypal Currency</label>
                      <select class="form-control" name="paypal_currency">
                        <option {{ (old('paypal_currency', $getRecord->paypal_currency) == 'USD') ? 'selected' : '' }}  value="USD">USD Doller</option>
                        <option {{ (old('paypal_currency', $getRecord->paypal_currency) == 'INR') ? 'selected' : '' }} value="INR">Indian Rupees</option>
                        <option {{ (old('paypal_currency', $getRecord->paypal_currency) == 'NPR') ? 'selected' : '' }} value="NPR">Nepali Rupees</option>
                      </select>
                    </div>     

                    <div class="form-group col-md-6">
                      <label>Stripe Public Key</label>
                      <input type="text" class="form-control" name="stripe_key" value="{{ $getRecord->stripe_key }}" placeholder="Stripe Public Key">
                    </div> 

                    <div class="form-group col-md-6">
                      <label>Stripe Secret Key</label>
                      <input type="text" class="form-control" name="stripe_secret" value="{{ $getRecord->stripe_secret }}" placeholder="Stripe Private Key">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Stripe Currency</label>
                      <select class="form-control" name="stripe_currency">
                        <option {{ (old('stripe_currency', $getRecord->stripe_currency) == 'usd') ? 'selected' : '' }}  value="usd">USD Doller</option>
                        <option {{ (old('stripe_currency', $getRecord->stripe_currency) == 'inr') ? 'selected' : '' }} value="inr">Indian Rupees</option>
                        <option {{ (old('stripe_currency', $getRecord->stripe_currency) == 'npr') ? 'selected' : '' }} value="npr">Nepali Rupees</option>
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Khalti Public Key</label>
                      <input type="text" class="form-control" name="khalti_public_key" value="{{ $getRecord->khalti_public_key }}" placeholder="Khalti Public Key">
                    </div> 

                    <div class="form-group col-md-6">
                      <label>Khalti Secret Key</label>
                      <input type="text" class="form-control" name="khalti_secret_key" value="{{ $getRecord->khalti_secret_key }}" placeholder="Khalti Private Key">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Esewa Public Key</label>
                      <input type="text" class="form-control" name="esewa_public_key" value="{{ $getRecord->esewa_public_key }}" placeholder="Esewa Public Key">
                    </div> 

                    <div class="form-group col-md-6">
                      <label>Esewa Secret Key</label>
                      <input type="text" class="form-control" name="esewa_secret_key" value="{{ $getRecord->esewa_secret_key }}" placeholder="Esewa Private Key">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Logo</label>
                      <input type="file" class="form-control" name="logo">
                      @if(!empty($getRecord->getLogo()))
                        <img src="{{ $getRecord->getLogo() }}" style="width:auto; height:50px">
                      @endif
                    </div>

                    <div class="form-group col-md-6">
                      <label>Favicon Icon</label>
                      <input type="file" class="form-control" name="favicon_icon">
                      @if(!empty($getRecord->getFavicon()))
                        <img src="{{ $getRecord->getFavicon() }}" style="width:auto; height:50px">
                      @endif
                    </div>

                    <div class="form-group col-md-6">
                      <label>School Name</label>
                      <input type="text" class="form-control" name="school_name" value="{{ $getRecord->school_name }}" placeholder="School Name">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Exam Description</label>
                      <textarea class="form-control" name="exam_description">{{ $getRecord->exam_description }}</textarea>
                    </div>

                  </div>              

                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        
      </div>
    </section>
  </div>


@endsection