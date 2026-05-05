@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-panel">
    <div class="ta-panel-head"><div><span class="ta-kicker">System</span><h2>Core Settings</h2></div><i class="las la-cog"></i></div>
    <form class="ta-settings-form" method="POST" action="{{ route('toapp.admin.settings.update') }}">
        @csrf
        @method('PUT')
        <div class="ta-two-col">
            <label class="ta-field"><span>Site Name</span><input name="site_name" value="{{ old('site_name', $settings->site_name) }}" required maxlength="40"></label>
            <label class="ta-field"><span>Rows Per Page</span><input name="paginate_number" type="number" min="5" max="100" value="{{ old('paginate_number', $settings->paginate_number ?: 20) }}" required></label>
        </div>
        <div class="ta-two-col">
            <label class="ta-field"><span>Currency Text</span><input name="cur_text" value="{{ old('cur_text', $settings->cur_text) }}" required maxlength="40"></label>
            <label class="ta-field"><span>Currency Symbol</span><input name="cur_sym" value="{{ old('cur_sym', $settings->cur_sym) }}" required maxlength="40"></label>
        </div>
        <div class="ta-two-col">
            <label class="ta-field"><span>Email From</span><input name="email_from" type="email" value="{{ old('email_from', $settings->email_from) }}" maxlength="40"></label>
            <label class="ta-field"><span>Email Sender Name</span><input name="email_from_name" value="{{ old('email_from_name', $settings->email_from_name) }}" maxlength="255"></label>
        </div>
        <div class="ta-switch-grid">
            <label><input type="checkbox" name="registration" value="1" @checked(old('registration', $settings->registration))> Registration open</label>
            <label><input type="checkbox" name="ev" value="1" @checked(old('ev', $settings->ev))> Require email verification</label>
            <label><input type="checkbox" name="sv" value="1" @checked(old('sv', $settings->sv))> Require mobile verification</label>
            <label><input type="checkbox" name="kv" value="1" @checked(old('kv', $settings->kv))> Require KYC</label>
            <label><input type="checkbox" name="maintenance_mode" value="1" @checked(old('maintenance_mode', $settings->maintenance_mode))> Maintenance mode</label>
            <label><input type="checkbox" name="secure_password" value="1" @checked(old('secure_password', $settings->secure_password))> Secure password rules</label>
        </div>
        <button class="ta-primary-btn ta-fit-btn" type="submit">Save Settings</button>
    </form>
</section>
@endsection
