@extends('auth.index')
@section('content')
    <div class="content">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="header">
            <p class="lead">Login to your account</p>
        </div>
        <form class="form-auth-small" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="signin-email" class="control-label sr-only">Email</label>
                <input type="email" name="email" class="form-control" id="signin-email" value="" placeholder="Email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="signin-password" class="control-label sr-only">Password</label>
                <input type="password" name="password" class="form-control" id="signin-password" value="" placeholder="Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            {{-- <div class="form-group clearfix">
                <label class="fancy-checkbox element-left">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <span for="remember">
                        {{ __('Remember Me') }}
                    </span>
                </label>
            </div> --}}
            <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
            {{-- <div class="bottom">
                @if (Route::has('password.request'))
                    <span class="helper-text"><i class="fa fa-lock"></i>
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </span>
                @endif
            </div> --}}
        </form>
    </div>
@endsection
