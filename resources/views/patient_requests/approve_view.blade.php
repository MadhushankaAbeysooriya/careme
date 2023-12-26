@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Approve/Reject</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item ">Job Management</li>
                  <li class="breadcrumb-item active">Approve/Reject</li>
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
                            <h3 class="card-title">Approve/Reject Job - {{ $patientRequest->patient->name  }} - {{ $patientRequest->total_price }}</h3>
                            {{-- <div class="card-tools">
                                <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                            </div> --}}
                        </div>

                        <form role="form" method="POST" action="{{route('patient_requests.approve', $patientRequest->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <img class="img-fluid"
                                src="{{ asset($patientRequest->patientrequestpayment->filepath ?? asset('upload/personalphotos/default.jpg'))}}"
                                alt=" " style="max-height: 400px;">
                            </div>

                                <div class="card-footer">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm bg-info"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                        <button type="submit" class="btn btn-sm btn-success" >Approve</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
@endsection
