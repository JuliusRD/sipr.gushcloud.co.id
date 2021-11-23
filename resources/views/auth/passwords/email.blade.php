@extends('auth.index')
@section('content')
    <div class="content">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="header">
            <p class="lead">{{ __('Reset Password') }}</p>
        </div>
        <form class="form-auth-small" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="signin-email" class="control-label sr-only">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
           
            <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('Send Password Reset Link') }}</button>
            
        </form>
    </div>
@endsection
