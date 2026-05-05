@extends($activeTemplate.'layouts.frontend')

@include($activeTemplate . 'partials.auth_ui')

@section('content')
    <div class="auth-surface">
        <div class="auth-shell">
            <div class="auth-topbar">
                <a class="auth-back" href="{{ route('user.login') }}" aria-label="@lang('Back to login')">
                    <i class="las la-arrow-left"></i>
                </a>
                <a class="auth-link" href="{{ route('user.login') }}">@lang('Login')</a>
            </div>

            <div class="auth-card">
                <div class="auth-card__header">
                    <span class="auth-eyebrow">@lang('Account recovery')</span>
                    <h1 class="auth-title">@lang('Reset password')</h1>
                    <p class="auth-copy">@lang('Enter your registered email or username and we will send the recovery code.')</p>
                </div>

                <div class="auth-card__body">
                    @if ($errors->any())
                        <div class="auth-error-summary">
                            @foreach ($errors->all() as $error)
                                <div>{{ __($error) }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.password.email') }}" class="auth-form auth-enhanced-form verify-gcaptcha">
                        @csrf

                        <div class="auth-field">
                            <label class="auth-label" for="value">@lang('Email or Username')</label>
                            <input
                                id="value"
                                type="text"
                                name="value"
                                class="auth-control"
                                value="{{ old('value') }}"
                                placeholder="@lang('Email or username')"
                                autocomplete="username"
                                required
                                autofocus="off"
                            >
                            <p class="auth-help">@lang('Check your inbox and spam folder after submitting.')</p>
                        </div>

                        @include('partials.captcha')

                        <button type="submit" class="auth-submit" data-loading-text="@lang('Sending code...')">
                            @lang('Send Recovery Code')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
