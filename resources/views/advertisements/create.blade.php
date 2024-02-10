@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Advertisement</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item ">Master Data</li>
                  <li class="breadcrumb-item ">Advertisement Management</li>
                  <li class="breadcrumb-item active">Create</li>
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
                            <h3 class="card-title">Create New Advertisement</h3>
                            {{-- <div class="card-tools">
                                <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                            </div> --}}
                        </div>

                        <form role="form" method="POST" action="{{route('advertisements.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="advertisement_category_id" class="col-sm-2 col-form-label">Category</label>
                                    <div class="col-sm-6">
                                        <select class="form-control @error('advertisement_category_id') is-invalid @enderror"
                                            name="advertisement_category_id" value="{{ old('advertisement_category_id') }}" id="advertisement_category_id" required>
                                            <option value="">Please Select</option>
                                            @foreach ($advertisementCategories as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('advertisement_category_id')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('name')
                                        is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" autocomplete="off">
                                        <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="from" class="col-sm-2 col-form-label">From</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control @error('from')
                                        is-invalid @enderror" name="from" value="{{ old('from') }}" id="from" autocomplete="off" min="1">
                                        <span class="text-danger">@error('from') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="to" class="col-sm-2 col-form-label">To</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control @error('to')
                                        is-invalid @enderror" name="to" value="{{ old('to') }}" id="to" autocomplete="off" min="1">
                                        <span class="text-danger">@error('to') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row" >
                                    <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control @error('amount')
                                        is-invalid @enderror" name="amount" value="{{ old('amount') }}" id="amount" autocomplete="off" min="1" readonly>
                                        <span class="text-danger">@error('amount') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row" >
                                    <label for="total" class="col-sm-2 col-form-label">Total</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control @error('total')
                                        is-invalid @enderror" name="total" value="{{ old('total') }}" id="total" autocomplete="off" min="1" readonly>
                                        <span class="text-danger">@error('total') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="url" class="col-sm-2 col-form-label">Url</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('url')
                                        is-invalid @enderror" name="url" value="{{ old('url') }}" id="url" autocomplete="off">
                                        <span class="text-danger">@error('url') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label for="filepath" class="col-sm-2 col-form-label">Select Image<sup class="text-red">*</sup></label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control @error('filepath') is-invalid @enderror"
                                        name="filepath" value="{{ old('filepath') }}" required accept=".jpeg,.png,.jpg">
                                        <span class="text-danger">@error('filepath') {{ $message }}
                                        @enderror</span>
                                    </div>
                                </div>

                            </div>

                                <div class="card-footer">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm bg-info"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                        <button type="reset" class="btn btn-sm btn-secondary">Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-success" >Create</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
@endsection

@section('third_party_scripts')
    <script>

            $('#advertisement_category_id, #from, #to').on('change', function() {
                var advertisement_category_id = $('#advertisement_category_id').val();
                var from = $('#from').val();
                var to = $('#to').val();

                if(advertisement_category_id && from && to)
                {
                    console.log('in');

                    // Make an AJAX request to fetch details from the API
                    $.ajax({
                        url: '{{ route('ajax.getAdvertisementTotal') }}',
                        method: 'GET',
                        data: {
                            advertisement_category_id: advertisement_category_id,
                            from: from,
                            to: to
                        },
                        success: function(data) {
                            // Clear existing options
                            $('#amount').empty();
                            $('#total').empty();

                            $('#amount').val(data.amount);
                            $('#total').val(data.total);

                        },
                        error: function(error) {
                            console.log('Invalid');
                        }
                    });
                }
            });


    </script>
@endsection
