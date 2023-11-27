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
                    <h3 class="card-title">View User</h3>
                    {{-- <div class="card-tools">
                        <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                    </div> --}}
                </div>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Name:</strong>
                        </label>
                        <div class="col-sm-10">
                            {{ $user->name }}
                        </div>
                    </div>

                    @if ($user->email)
                        <div class="form-group row">
                            <label class="col-sm-2">
                                <strong>Email:</strong>
                            </label>
                            <div class="col-sm-10">
                                {{ $user->email }}
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-sm-2">
                            <strong>Phone:</strong>
                        </label>
                        <div class="col-sm-10">
                            {{ $user->phone }}
                        </div>
                    </div>

                    @if(!$user->getRoleNames()->isEmpty())
                        <div class="form-group row">
                            <label class="col-sm-2">
                                <strong>Roles:</strong>
                            </label>
                            <div class="col-sm-10">
                                    @foreach($user->getRoleNames() as $v)
                                        <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-sm bg-info"><i class="fa fa-arrow-circle-left"></i> Back</a>
                    <a href="{{ route('users.validated',['id' => encrypt($user->id)]) }}" class="btn btn-sm btn-success">Validate</a>

                        {{-- <button class="btn btn-sm btn-primary" onclick="showAlert()">Show Alert</button> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
