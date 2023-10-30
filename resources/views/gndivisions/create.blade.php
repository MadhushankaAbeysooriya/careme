@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>GN Division</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item ">Master Data</li>
                  <li class="breadcrumb-item ">GN Division Management</li>
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
                            <h3 class="card-title">Create New GN Division</h3>
                            {{-- <div class="card-tools">
                                <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                            </div> --}}
                        </div>

                        <form role="form" method="POST" action="{{route('gndivisions.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="dsdivision_id" class="col-sm-2 col-form-label">District</label>
                                    <div class="col-sm-6">
                                        <select class="form-control @error('dsdivision_id') is-invalid @enderror"
                                            name="dsdivision_id" value="{{ old('dsdivision_id') }}" id="dsdivision_id" required>
                                            <option value="">Please Select</option>
                                            @foreach ($dsdivisions as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('dsdivision_id')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">GN Division</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('name')
                                        is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" autocomplete="off">
                                        <span class="text-danger">@error('name') {{ $message }} @enderror</span>
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
