@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </div>
              </div>
        </section>

        <div class="container-fluid">
            <div class="row mb-2 ml-3">
                <form class="form-inline my-2 my-lg-0" role="form" method="POST" action="{{ route('searchdetail') }}"
                    enctype="multipart/form-data" id="searchForm">
                    @csrf

                    <input class="form-control mr-sm-2" type="search" placeholder="NIC" aria-label="Search" name="search" value="{{ old('search') }}">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>

            </div>
        </div>

        @if (isset($message))
            <div id="searchMessage">
                @if ($message)
                    <div class="col-sm-6 alert @if ($reply === 1) alert-success @else alert-danger @endif">
                        {{ $message }}
                    </div>
                @endif
            </div>            
        @endif    
           

        {{-- <div class="modal fade" id="searchResultModal" tabindex="-1" role="dialog" aria-labelledby="searchResultModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchResultModalLabel">Search Result</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($reply === 1)
                            <div class="text-success">✔</div>
                        @else
                            <div class="text-danger">✘</div>
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}
        
        
    </div>
@endsection

@section('third_party_scripts')
    {{-- <script>
        $(document).ready(function () {
            // Handle form submission
            $('#loginForm').submit(function (e) {
                e.preventDefault();
                var email = 'admin@gmail.com';
                var password = 'Abcd@1234';

                // Use Guzzle to make the API request
                guzzle.get('http://10.7.113.84/ashi_api/api/login?email=' + email + '&password=' + password)
                    .then(function (response) {
                        // Assuming the API response includes a "token" property
                        var token = response.data.token;

                        // Display the token
                        console.log($('#tokenValue').text(token));
                        $('#tokenResult').show();
                    })
                    .catch(function (error) {
                        // Handle errors if the API request fails
                        console.log("API request failed:", error);
                    });
            });
        });
    </script>         --}}
@endsection
