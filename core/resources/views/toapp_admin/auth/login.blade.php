@extends('toapp_admin.layouts.auth')

@section('content')
<main class="ta-auth">
    <div class="ta-auth-orb ta-auth-orb-one"></div>
    <div class="ta-auth-orb ta-auth-orb-two"></div>

    <section class="ta-auth-panel">
        <div class="ta-auth-copy">
            <a class="ta-auth-brand" href="{{ route('toapp.admin.login') }}">
                <span class="ta-brand-mark">T</span>
                <span>
                    <strong>To-app Control</strong>
                    <small>Independent admin backend</small>
                </span>
            </a>

            <span class="ta-kicker">Private Operations Console</span>
            <h1>Built to run the platform without the old Envato gate.</h1>
            <p>Manage users, plans, deposits, withdrawals, support, reports, payment methods, and launch readiness from one clean control room.</p>

            <div class="ta-auth-metrics">
                <div>
                    <strong>12</strong>
                    <span>Admin screens</span>
                </div>
                <div>
                    <strong>0</strong>
                    <span>Activation locks</span>
                </div>
                <div>
                    <strong>24/7</strong>
                    <span>Ops ready</span>
                </div>
            </div>

            <div class="ta-auth-status">
                <span></span>
                <strong>Phase 4 backend online</strong>
            </div>
        </div>

        <form class="ta-login-card" method="POST" action="{{ route('toapp.admin.login.submit') }}">
            @csrf
            <div class="ta-login-glow"></div>
            <div class="ta-form-head">
                <span class="ta-login-lock"><i class="las la-shield-alt"></i></span>
                <div>
                    <span class="ta-kicker">Secure Sign In</span>
                    <h2>Welcome back</h2>
                    <p>Sign in with your admin account to continue operations.</p>
                </div>
            </div>

            @if($errors->any())
                <div class="ta-alert ta-alert-danger">{{ $errors->first() }}</div>
            @endif

            <label class="ta-field ta-field-icon">
                <span>Username</span>
                <i class="las la-user"></i>
                <input type="text" name="username" value="{{ old('username') }}" autocomplete="username" required autofocus>
            </label>

            <label class="ta-field ta-field-icon">
                <span>Password</span>
                <i class="las la-key"></i>
                <input type="password" name="password" autocomplete="current-password" required>
            </label>

            <div class="ta-login-options">
                <label class="ta-check">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
                    <span>Keep me signed in</span>
                </label>
                <span class="ta-secure-note"><i class="las la-lock"></i> Admin guard active</span>
            </div>

            <button class="ta-primary-btn" type="submit">
                <i class="las la-lock-open"></i>
                <span>Enter Control Room</span>
            </button>

            <div class="ta-login-footer">
                <i class="las la-info-circle"></i>
                <span>Use the seeded admin credentials from your local setup. Rotate them before production launch.</span>
            </div>
        </form>
    </section>
</main>
@endsection
