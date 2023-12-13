@extends('layouts.app')


@section('content')

<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Deposit Payment</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item ">Master Data</li>
                <li class="breadcrumb-item ">Deposit Payment</li>
                <li class="breadcrumb-item active">All</li>
              </ol>
            </div>
        </div>
    </section>

    <div class="card card-teal">
        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-user-circle"></i>
                All Deposit Payment
            </h3>

            <div class="card-tools">
                <div class="input-group input-group-sm ">
                </div>
            </div>
        </div>
            <div class="card-body">
                {{$dataTable->table()}}
            </div>
    </div>

</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
