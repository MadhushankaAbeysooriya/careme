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

@endsection
