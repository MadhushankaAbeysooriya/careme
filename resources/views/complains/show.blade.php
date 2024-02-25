@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Complain</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item ">Complain Management</li>
                  <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
          </div>
    </section>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-teal">
                <div class="card-header">
                    <h3 class="card-title">View Complain</h3>
                    <div class="card-tools">
                        <a class="btn btn-primary" href="{{ route('complains.index') }}"> Back</a>
                    </div>
                </div>

                <form role="form" action="{{ route('complains.update',$complain->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-sm-2">
                                <strong>Topic:</strong>
                            </label>
                            <div class="col-sm-10">
                                {{ $complain->topic ? $complain->topic:'N/A' }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">
                                <strong>Complain:</strong>
                            </label>
                            <div class="col-sm-10">
                                {{ $complain->complain ? $complain->complain:'N/A' }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">
                                <strong>User:</strong>
                            </label>
                            <div class="col-sm-10">
                                {{ $complain->user_id ? $complain->user->name:'N/A'}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">
                                <strong>Date:</strong>
                            </label>
                            <div class="col-sm-10">
                                {{ $complain->created_at ? $complain->created_at:'N/A'}}
                            </div>
                        </div>

                        @if ($complain->patient_request_id)
                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>Job Ref:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patient_request_id ? $complain->patient_request_id:'N/A'}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>Hospital:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patientrequest->hospital ? $complain->patientrequest->hospital->name:'N/A'}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>Care Taker:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patientrequest->caretaker ? $complain->patientrequest->caretaker->name:'N/A'}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>Patient:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patientrequest->patient ? $complain->patientrequest->patient->name:'N/A'}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>Start:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patientrequest->from ? $complain->patientrequest->from:'N/A'}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>End:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patientrequest->to ? $complain->patientrequest->to:'N/A'}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>Hours:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patientrequest->hrs ? $complain->patientrequest->hrs:'N/A'}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>Svc Charge:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patientrequest->svc_charge ? 'Rs. '.number_format($complain->patientrequest->svc_charge, 2) : 'N/A' }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>Total Price:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patientrequest->total_price ? 'Rs. '.number_format($complain->patientrequest->total_price, 2) : 'N/A' }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>Payment Method:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patientrequest->paymentmethod ? $complain->patientrequest->paymentmethod->name:'N/A'}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">
                                    <strong>Gender:</strong>
                                </label>
                                <div class="col-sm-10">
                                    {{ $complain->patientrequest->gender ? $complain->patientrequest->gender:'N/A'}}
                                </div>
                            </div>
                        @endif


                            <div class="form-group row">
                                <label for="remarks" class="col-sm-2 col-form-label">Remarks</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control @error('remarks')
                                    is-invalid @enderror" name="remarks" id="remarks" required rows="4" autocomplete="off"
                                    {{ $complain->remarks ? 'disabled' : '' }}>{{ $complain->remarks == null ? old('remarks'):$complain->remarks }}</textarea>
                                    <span class="text-danger">@error('remarks') {{ $message }} @enderror</span>
                                </div>
                            </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-sm bg-info"><i class="fa fa-arrow-circle-left"></i> Back</a>
                            <button type="reset" class="btn btn-sm btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-success" {{ $complain->remarks ? 'hidden' : '' }}>Resolve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
