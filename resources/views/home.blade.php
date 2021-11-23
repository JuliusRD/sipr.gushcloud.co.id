@extends('layouts.index')
@section('title')
    Home | SIPR
@endsection
@section('header')
    <div class="page-header text-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Home Dashboard
                </div>
                <h2 class="page-title">
                    Home
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('profile.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="44"
                            height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" />
                            <line x1="13.5" y1="6.5" x2="17.5" y2="10.5" />
                        </svg>
                        Profile Edit
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">

        <div class="col-md-12 col-lg-9 d-block">
            <div class="card">
                <div class="card-header d-block d-sm-flex justify-content-between">
                    <div>
                        <h3 class="card-title">Recent Activity</h3>
                    </div>
                </div>
                @forelse ($history as $key => $data)
                    @php
                    if(!empty($data->purchase->request_by)){
                        if ($data->purchase->request_by == Auth::id()) {
                            $url = route('purchase.show', $data->purchase_id);
                        } else {
                            $url = route('approval.show', $data->purchase_id);
                        }
                        }
                    @endphp
                    <a href="{{ $url ?? ''}}">
                        <div class="card-body">
                            <div class="divide-y">
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            @if (!empty($data->user->role))
                                                @switch($data->user->role)
                                                    @case($data->user->role == 'Leader')
                                                        @if ($data->user->divisi->nama == 'Finance')
                                                            <span class="bg-yellow text-white avatar"><svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-users" width="44"
                                                                    height="44" viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="#ffffff" fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <circle cx="9" cy="7" r="4"></circle>
                                                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                                                </svg>
                                                            </span>
                                                        @else
                                                            <span class="bg-blue text-white avatar"><svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-users" width="44"
                                                                    height="44" viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="#ffffff" fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <circle cx="9" cy="7" r="4"></circle>
                                                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    @break
                                                    @case($data->user->role == 'Employee')
                                                        <span class="bg-dark text-white avatar"><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-users" width="44"
                                                                height="44" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="#ffffff" fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <circle cx="9" cy="7" r="4"></circle>
                                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                                            </svg>
                                                        </span>
                                                    @break
                                                    @default
                                                @endswitch
                                            @endif
                                        </div>
                                        <div class="col">
                                            <div class="text-truncate">
                                                <strong>{{ $data->user->name ?? '' }}</strong> {{ $data->status }}
                                                purchase
                                                order
                                                <strong>{{ $data->purchase->purchase_code ?? '' }}</strong>
                                            </div>
                                            <div class="text-muted">
                                                {{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</div>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            @if (!empty($data->user->role))
                                                @switch($data->user->role)
                                                    @case($data->user->role == 'Leader')
                                                        @if ($data->user->divisi->nama == 'Finance')
                                                            <span
                                                                class="badge bg-yellow-lt">{{ $data->user->divisi->nama }}</span>
                                                        @else
                                                            <span class="badge bg-blue-lt">{{ $data->user->role }}</span>
                                                        @endif
                                                    @break
                                                    @case($data->user->role == 'Employee')
                                                        <span class="badge bg-dark-lt">{{ $data->user->role }}</span>
                                                    @break
                                                    @default
                                                @endswitch
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                        <div class="card-body">
                            <div class="divide-y">
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="text-truncate">
                                                Data not found
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                    <div class="card-footer">
                        <a href="{{ route('history.index') }}" class="btn btn-primary">View More</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection
