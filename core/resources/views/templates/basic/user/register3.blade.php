@extends($activeTemplate.'layouts.frontend')

@include($activeTemplate . 'partials.auth_ui')

@section('content')
    <div class="auth-surface">
        <div class="auth-shell">
            <div class="auth-topbar">
                <a class="auth-back" href="{{ route('user.data') }}" aria-label="@lang('Back')">
                    <i class="las la-arrow-left"></i>
                </a>
                <span class="auth-optional">@lang('Final step')</span>
            </div>

            <div class="auth-card">
                <div class="auth-card__header">
                    <span class="auth-eyebrow">@lang('Step 3 of 3')</span>
                    <h1 class="auth-title">@lang('Secure your account')</h1>
                    <p class="auth-copy">@lang('Create a password you can remember but other people cannot guess.')</p>
                </div>

                <div class="auth-card__body">
                    <div class="auth-progress" aria-label="@lang('Registration progress')">
                        <span class="auth-step is-complete"></span>
                        <span class="auth-step is-complete"></span>
                        <span class="auth-step is-active"></span>
                    </div>

                    @if ($errors->any())
                        <div class="auth-error-summary">
                            @foreach ($errors->all() as $error)
                                <div>{{ __($error) }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form class="auth-form auth-enhanced-form" action="{{ route('user.register3.submit') }}" method="post">
                        @csrf

                        <div class="auth-field">
                            <label class="auth-label" for="password-toggle">@lang('Password')</label>
                            <div class="auth-password-wrap">
                                <input
                                    id="password-toggle"
                                    type="password"
                                    class="auth-control @if (gs('secure_password')) secure-password @endif"
                                    name="password"
                                    placeholder="@lang('Create password')"
                                    autocomplete="new-password"
                                    required
                                >
                                <button class="auth-password-toggle" type="button" data-target="#password-toggle" aria-label="@lang('Show password')">
                                    <i class="las la-eye"></i>
                                </button>
                            </div>
                            <p class="auth-help">@lang('Use at least 6 characters. A mix of letters, numbers, and symbols is best.')</p>
                        </div>

                        <div class="auth-field">
                            <label class="auth-label" for="password-toggleconfirm">@lang('Confirm Password')</label>
                            <div class="auth-password-wrap">
                                <input
                                    id="password-toggleconfirm"
                                    type="password"
                                    class="auth-control"
                                    name="password_confirmation"
                                    placeholder="@lang('Repeat password')"
                                    autocomplete="new-password"
                                    required
                                >
                                <button class="auth-password-toggle" type="button" data-target="#password-toggleconfirm" aria-label="@lang('Show password')">
                                    <i class="las la-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="auth-note">
                            <span class="auth-note__icon">i</span>
                            <span>@lang('After this step your account will be created and you will enter the dashboard automatically.')</span>
                        </div>

                        <button type="submit" class="auth-submit" data-loading-text="@lang('Creating account...')">
                            @lang('Complete Account')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@if(gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
