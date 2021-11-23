@extends('layouts.index')
@section('title')
    New Division | SIPR
@endsection
@section('header')
    <div class="page-header text-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Division Management
                </div>
                <h2 class="page-title">
                    {{ $institusi_name ?? ''}} <svg xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-chevrons-right" width="44" height="44" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <polyline points="7 7 12 12 7 17" />
                        <polyline points="13 7 18 12 13 17" />
                    </svg> New Division
                </h2>
            </div>

        </div>
    </div>
@endsection
@section('content')
    <div class="row row-deck row-cards">
        <div class="col-md-2">
            <div class="row row-cards">
                <div class="col-12">
                    <a href="{{ route('institusi_divisi.index', $institusi_id) }}">
                        <div class="card card-sm mb-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-dark text-white avatar">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-chevron-left" width="44" height="44"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <polyline points="15 6 9 12 15 18" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Cancel
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
        <div class="col-md-12 col-lg-10">
            <div class="card">
                <div class="card-header d-block d-sm-flex justify-content-between">
                    <div>
                        <h3 class="card-title">Create Division</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('divisi.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Division Name</label>
                            <input type="text" class="form-control" name="nama" placeholder="Division Name" required>
                        </div>
                        <input type="hidden" name="institusi_id" value="{{$institusi_id}}">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
