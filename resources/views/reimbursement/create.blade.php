@extends('layouts.index')
@section('title')
    Reimbursement Request | SIPR
@endsection
@section('header')
    <div class="page-header text-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Manajemen Reimbursement
                </div>
                <h2 class="page-title">
                    Reimbursement Request
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
                    <a href="{{ route('reimbursement.index') }}">
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
                <ul class="nav nav-tabs " data-bs-toggle="tabs">
                    <li class="nav-item">
                        <a href="#tabs-home-17" class="nav-link active" data-bs-toggle="tab">
                            <h3 class="card-title text-dark my-2">Step 1: Reimbursement Request</h3>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#tabs-profile-17" class="nav-link disabled" data-bs-toggle="tab">
                            <h3 class="card-title my-2">Step 2: Detail</h3>
                        </a>
                    </li>

                </ul>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tabs-home-17">
                            <form action="{{ route('reimbursement.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label class="form-label">Request By</label>
                                        <input type="text" class="form-control" name="request-by" placeholder="Request By"
                                            value="{{ $current_user->name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label">Organization</label>
                                        <select name="institusi_id" class="form-select" name="institusi_id" id="institusi_option" required>
                                            @forelse ($institusi as $id => $nama)
                                                <option value="{{ $id }}">{{ $nama }}</option>
                                            @empty
                                                <option disabled selected>Data not found</option>
                                            @endforelse
                                        </select>
                                    </div>                                    
                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label">Division</label>
                                        <select name="divisi_id" class="form-select" name="divisi_id" id="divisi_option" required>
                                            @forelse ($divisi as $id => $nama)
                                                <option value="{{ $id }}">{{ $nama }}</option>
                                            @empty
                                                <option disabled selected>Data not found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label">Leader</label>
                                         <select name="leader_id" class="form-select" id="leader_option" required>
                                            @forelse ($leader as $id => $nama)
                                                <option value="{{ $id }}">{{ $nama }}</option>
                                            @empty
                                                <option disabled selected>Data not found</option>
                                            @endforelse
                                        </select>
                                    </div>                                
                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label">Request Date</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                                                    <line x1="16" y1="3" x2="16" y2="7"></line>
                                                    <line x1="8" y1="3" x2="8" y2="7"></line>
                                                    <line x1="4" y1="11" x2="20" y2="11"></line>
                                                    <line x1="11" y1="15" x2="12" y2="15"></line>
                                                    <line x1="12" y1="15" x2="12" y2="18"></line>
                                                </svg>
                                            </span>
                                            <input class="form-control" name="request_date" placeholder="Select a request date" id="request-date-picker"
                                                value="{{date('Y-m-d')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Notes (Reason of Request)..</label>
                                        <textarea class="form-control" name="note" rows="6"
                                            placeholder="Harap masukkan link pembelian" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">
                                            Selanjutnya
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tabs-profile-17">
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
@section('custom-js')
<script src="{{asset('js/litepicker.js')}}"></script>
<script>
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
                    if(!$.trim(JSON.parse(data.data))){
                        $select.html('');
                        $select.append('<option value="">Division doesnt exist / Select Organization First</option>');
                    }else{
                        $select.html('');
                        $select.append('<option value="">Select Division</option>');
                        $.each(JSON.parse(data.data), function(key, value) {
                            $select.append('<option value=' + key + '>' + value + '</option>');
                        });
                    }
                }
            });
        });
    });
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        window.Litepicker && (new Litepicker({
          element: document.getElementById('request-date-picker'),
          buttonText: {
            previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>`,
            nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>`,
          },
        }));
      });
      // @formatter:on
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
        window.Litepicker && (new Litepicker({
          element: document.getElementById('due-date-picker'),
          buttonText: {
            previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>`,
            nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>`,
          },
        }));
      });
      // @formatter:on
      $("a.nav-link").removeAttr("href");
</script>
@endsection
