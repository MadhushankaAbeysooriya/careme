@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item ">System Management</li>
                  <li class="breadcrumb-item ">User Management</li>
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
                            <h3 class="card-title">Create New User</h3>
                            {{-- <div class="card-tools">
                                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                            </div> --}}
                        </div>

                        <form role="form" method="POST" action="{{route('users.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('name')
                                        is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" autocomplete="off">
                                        <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('email')
                                        is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" autocomplete="off">
                                        <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('phone')
                                        is-invalid @enderror" name="phone" value="{{ old('phone') }}" id="phone" autocomplete="off">
                                        <span class="text-danger">@error('phone') {{ $message }} @enderror</span>
                                    </div>
                                </div>
                                

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="roles">Role</label>
                                    <div class="col-sm-6 select2-blue">
                                        <select required name="roles[]" id="roles" class="multiple form-control">
                                            @foreach($roles as $role)
                                                <option value="{{ $role }}">{{ $role }}</option>
                                            @endforeach
                                        </select>

                                        @error('roles')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>                                

                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control @error('password')
                                        is-invalid @enderror" name="password" value="{{ old('password') }}" id="password" autocomplete="off">
                                        <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="confirm-password" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control @error('confirm-password')
                                        is-invalid @enderror" name="confirm-password" value="{{ old('confirm-password') }}" id="confirm-password" autocomplete="off">
                                        <span class="text-danger">@error('confirm-password') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                </div>
                                <div class="card-footer">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm bg-info"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                        <button type="reset" class="btn btn-sm btn-secondary">Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-success" >Create</button>

                                        {{-- <button class="btn btn-sm btn-primary" onclick="showAlert()">Show Alert</button> --}}
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
                
@endsection


@section('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
@endsection

@section('third_party_scripts')
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}" ></script>
    <script src="{{asset('plugins/select2/js/select2.js')}}" defer></script>
        
@endsection
