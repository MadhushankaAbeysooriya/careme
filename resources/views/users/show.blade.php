@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="h3 text-capitalize"> {!! $user->name !!}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item ">System Management</li>
                    <li class="breadcrumb-item ">Care Taker User</li>
                    <li class="breadcrumb-item active">Show</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">

                        {{-- <a href="{{ url()->previous() }}" class="btn btn-sm bg-success"><i
                                class="fa fa-arrow-circle-left"></i> Back</a> --}}


                        <div class="text-center">
                            {{-- <img class="profile-user-img img-fluid " src="{{ asset('/uploads/useralphotos')}}/
                        {{$job_seeker->filepath ?? 'default.jpg'}}" alt=" "> --}}

                            @if ($user->caretakerprofile)
                                <img class="profile-user-img img-fluid "
                                src="{{ asset($user->caretakerprofile->personal_photo ?? asset('upload/personalphotos/default.jpg'))}}"
                                alt=" ">
                            @else
                                <img class="profile-user-img img-fluid "
                                src="{{ asset('upload/personalphotos/default.jpg')}}"
                                alt=" ">
                            @endif

                        </div>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Age</b> <a class="float-right"> {{ $age}}</a>
                            </li>
                        </ul>

                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ route('users.care_taker') }}" class="btn btn-success btn-block"><i
                                        class="fa fa-arrow-circle-left"></i> Back</a>
                            </div>


                            <div class="col-sm-6" >
                                <a href="{{ route('users.edit',$user->id) }}" class="btn btn-danger btn-block">
                                    <i class="fa fa-pen"></i> Edit</a>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                @if ($user->validated == 1)
                                    <h5><span class="badge badge-success">validated</span></h5>
                                @else
                                    <h5><span class="badge badge-warning">Not-validated</span></h5>
                                @endif

                            </div>

                            @if ($user->caretakerprofile)
                                <div class="col-sm-6">
                                    <p>{{ $user->caretakerprofile->description }}</p>
                                </div>
                            @endif

                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> Contact Details </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-phone mr-1"></i> Phone</strong>

                        <p class="text-muted">
                            {{ $user->phone }}
                        </p>

                        {{-- <hr>

                        <strong><i class="fas fa-mail-alt mr-1"></i> Email</strong>

                        <p class="text-muted"> {{ $user->email }} </p> --}}



                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Basic
                                    Informations </a></li>
                            <li class="nav-item"><a class="nav-link" href="#bookings" data-toggle="tab">Bookings</a></li>
                            {{-- <li class="nav-item"><a class="nav-link" href="#dependent" data-toggle="tab">Dependent
                                    Informations</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Card
                                    Informations</a></li> --}}

                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">

                                <table class="table table-hover">
                                    <tr>
                                        <th>First Name</th>
                                        <td>{{ $user->fname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last name</th>
                                        <td>{{ $user->lname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $user->gender }}</td>
                                    </tr>

                                    @if ($user->caretakerprofile)
                                        <tr>
                                            <th>Id Front</th>
                                            <td>
                                                @if ($user->caretakerprofile->id_front)
                                                    <a href="{{ asset($user->caretakerprofile->id_front) }}" class="btn btn-sm btn-dark" target="_blank">View</a>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Id Back</th>
                                            <td>
                                                @if ($user->caretakerprofile->id_back)
                                                    <a href="{{ asset($user->caretakerprofile->id_back) }}" class="btn btn-sm btn-dark" target="_blank">View</a>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Bank</th>
                                            <td>
                                                @if ($user->caretakerprofile->bank)
                                                    <a href="{{ asset($user->caretakerprofile->bank) }}" class="btn btn-sm btn-dark" target="_blank">View</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif

                                </table>

                                    <div class="footer">
                                        <a href="{{ url()->previous() }}" class="btn btn-sm bg-info"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                        @if ($user->validated == 0)
                                            <a href="{{ route('users.validated',['id' => encrypt($user->id)]) }}" class="btn btn-sm btn-success">Validate</a>
                                        @endif
                                    </div>


                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="bookings">
                                {{-- @if ($user->nok)
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Name with Initials</th>
                                            <td>{{ ($user->nok->name_with_initials !=null) ?
                                                $user->nok->name_with_initials:'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <th>Date Of Birth </th>
                                            <td>{{ ($user->nok->dob !=null) ? $user->nok->dob:'N/A'}}</td>
                                        </tr>

                                    </table>


                                @else
                                    N/A
                                @endif --}}

                                N/A

                            </div>


                            <!-- /.tab-pane -->

                            {{-- <div class="tab-pane" id="dependent">
                                @if ($user->dependence)

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Expandable Table</h3>
                                            </div>

                                            <div class="card-body">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Date of Birth</th>
                                                            <th>NIC</th>
                                                            <th>Relationship</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($user->dependence as $record)
                                                        @php
                                                            $i=1;
                                                        @endphp
                                                        <tr data-widget="expandable-table" aria-expanded="false">
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $record -> name_with_initials }}</td>
                                                            <td>{{ $record -> dob }}</td>
                                                            <td>{{ $record -> nic }}</td>
                                                            <td>{{ $record -> relationship -> name }}</td>
                                                        </tr>
                                                        <tr class="expandable-body d-none">
                                                            <td colspan="5">
                                                                <p style="display: none;">
                                                                    <strong>Ethnicity : </strong> {{ $record -> ethnicity -> name }}</br>
                                                                    <strong>Province : </strong> {{ $record -> province -> name }}</br>
                                                                    <strong>District : </strong> {{ $record -> district -> name }}</br>
                                                                    <strong>DS Division : </strong> {{ $record -> dsdivision -> name }}</br>
                                                                    <strong>Address : </strong> {{ $record -> address }}</br>
                                                                    <strong>Land No : </strong> {{ $record -> land_no  }}</br>
                                                                    <strong>Mobile No : </strong> {{ $record -> mobile_no }}</br>
                                                                    <strong>Email  : </strong> {{ $record -> email }} </br>

                                                                    @if ($record->photograph)
                                                                        <img class="profile-user-img img-fluid "
                                                                        src="{{ asset($record->photograph ?? asset('upload/useralphotos/default.jpg'))}}"
                                                                        alt=" ">
                                                                    @endif

                                                                    @if ($user->user_status_id == null
                                                                    && $user->user->force_id == auth()->user()->force_id)
                                                                        <div class="col-sm-2">
                                                                            <a href="{{ route('dependence.edit',['user'=>$user->id,'dependence'=>$record->id]) }}" class="btn btn-danger btn-block">
                                                                                <i class="fa fa-pen"></i> Edit</a>
                                                                        </div>
                                                                    @endif
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                @else
                                N/A
                                @endif
                            </div> --}}

                            <!-- /.tab-pane -->

                            {{-- <div class="tab-pane" id="settings">
                                @if ($user->nok)
                                details edit condition card
                                @else
                                N/A
                                @endif
                            </div> --}}

                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection

@section('third_party_stylesheets')

@stop

@section('third_party_scripts')

@stop
