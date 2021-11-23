@extends('layouts.index')
@section('title')
    Leader Detail | SIPR
@endsection
@section('header')
    <div class="page-header text-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Leader Management
                </div>
                <h2 class="page-title">
                    Leader Detail
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
                    <a href="{{ route('user.index') }}">
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
                                            Back
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
                <div class="card-header">
                    <h3 class="card-title">
                        Leader Detail
                    </h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-3">Name</dt>
                        <dd class="col-9">: {{$user->name}}</dd>
                        <dt class="col-3">Email</dt>
                        <dd class="col-9">: {{$user->email}}</dd>
                        <dt class="col-3">Organization</dt>
                        <dd class="col-9">: {!! $user->institusi->nama ?? '<small class="text-muxed"><i>Organization doesnt exist</i></small>' !!}</dd>
                        <dt class="col-3">Division</dt>
                        <dd class="col-9">: {!! $user->divisi->nama ?? '<small class="text-muxed"><i>Division doesnt exist</i></small>' !!}</dd>
                        <dt class="col-3">Role</dt>
                        <dd class="col-9">: {{$user->role}}</dd>
                        <dt class="col-3">Created At</dt>
                        <dd class="col-9">: {{$user->created_at}}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-js')
@endsection
