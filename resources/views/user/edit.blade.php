@extends('layouts.index')
@section('title')
    User  Edit | SIPR
@endsection
@section('header')
    <div class="page-header text-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    User Management
                </div>
                <h2 class="page-title">
                     User Edit
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
                        <h3 class="card-title"> User Edit: {{ $user->name ?? '' }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" placeholder="Full Name" name="name"
                                value="{{ $user->name ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" placeholder="Email" name="email"
                                value="{{ $user->email ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <small><i>*(If you don't want to change your password, please
                                        empty the field)</i></small></label>
                            <div class="input-group input-group-flat">
                                <input type="password" class="form-control" autocomplete="off" placeholder="Password"
                                    name="password" id="input-pw">
                                <span class="input-group-text">
                                    <a href="#!" id="check-pw" class="input-group-link">Show password</a>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Organization</label>
                            <select name="institusi_id" class="form-select" name="institusi_id" id="institusi_option"
                            required>
                                @forelse ($institusi as $id => $nama)
                                    <option value="{{ $id }}" {{ $user->institusi_id == $id ? 'selected' : '' }}>
                                        {{ $nama }} </option>
                                @empty
                                    <option disabled selected>Data not found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Division</label>
                            <select name="divisi_id" class="form-select" id="divisi_option" required>
                                @forelse ($divisi as $id => $nama)
                                    <option value="{{ $id }}" {{ $user->divisi_id == $id ? 'selected' : '' }}>
                                        {{ $nama }}</option>
                                @empty
                                    <option disabled selected>Data not found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <hr>
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
@section('custom-js')
    <script type='text/javascript'>
        $(document).ready(function() {
            $('#institusi_option').on('change', function() {
                $.ajax({
                    url: "{{ route('ajax.getdivisifrominstitusi') }}",
                    method: 'POST',
                    data: {
                        institusi_id: this.value,
                        _token: '{{ csrf_token() }}'
                    },
                    async: true,
                    dataType: "json",
                    success: function(data) {
                        var $select = $('#divisi_option');
                        if (!$.trim(JSON.parse(data.data))) {
                            $select.html('');
                            $select.append(
                                '<option value="">Division doesnt exist/Select Organization First</option>'
                            );
                        } else {
                            $select.html('');
                            $.each(JSON.parse(data.data), function(key, value) {
                                $select.append('<option value=' + key +
                                    '>' + value + '</option>');
                            });
                        }
                    }
                });
            });
            $('#check-pw').click(function() {
                if ('password' == $('#input-pw').attr('type')) {
                    $('#input-pw').prop('type', 'text');
                } else {
                    $('#input-pw').prop('type', 'password');
                }
            });
        });
    </script>
@endsection
