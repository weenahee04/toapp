@extends($activeTemplate . 'layouts.master')

@section('content')
<div class="app-page">
    <div class="app-container">
        <div class="app-topbar">
            <a class="app-icon-btn" href="{{ route('user.setting') }}" aria-label="@lang('Back to settings')">
                <i class="las la-arrow-left"></i>
            </a>
            <a class="app-brand" href="{{ route('user.home') }}">
                <img src="{{ siteLogo() }}" alt="To-app">
                <span>@lang('Withdraw Methods')</span>
            </a>
            <a class="app-icon-btn" href="{{ route('user.withdraw.history') }}" aria-label="@lang('Withdrawal history')">
                <i class="las la-history"></i>
            </a>
        </div>

        <section class="app-hero">
            <span class="app-eyebrow"><i class="las la-university"></i> @lang('Payout setup')</span>
            <h1>@lang('Choose a method when you request a withdrawal.')</h1>
            <p>@lang('Destination details are collected per request so admin can verify every payout manually and safely.')</p>
            <div class="app-hero-actions">
                <a class="app-btn app-btn-primary" href="{{ route('user.withdraw.index') }}">
                    <i class="las la-money-bill-wave"></i>
                    @lang('Start withdrawal')
                </a>
                <a class="app-btn app-btn-secondary" href="{{ route('user.withdraw.history') }}">
                    <i class="las la-receipt"></i>
                    @lang('History')
                </a>
            </div>
        </section>

        <div class="app-section-title">
            <div>
                <h2>@lang('Available methods')</h2>
                <p>@lang('Limits and charges are shown before you submit a payout.')</p>
            </div>
        </div>

        <div class="row app-grid">
            @forelse ($withdrawMethods as $method)
                <div class="col-md-6">
                    <div class="app-card app-method-card">
                        <div class="d-flex align-items-start gap-3">
                            <span class="app-list-icon"><i class="las la-wallet"></i></span>
                            <div class="app-list-body">
                                <strong>{{ $method->name }}</strong>
                                <span>{{ $method->currency }}</span>
                            </div>
                        </div>

                        <div class="withdraw-summary-box mt-3">
                            <div><span>@lang('Limit')</span><strong>{{ showAmount($method->min_limit) }} - {{ showAmount($method->max_limit) }}</strong></div>
                            <div><span>@lang('Charge')</span><strong>{{ showAmount($method->fixed_charge) }} + {{ showAmount($method->percent_charge, 2, false, false, false) }}%</strong></div>
                            <div><span>@lang('Processing')</span><strong>@lang('Manual review')</strong></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="app-empty-state">
                        <i class="las la-university d-block fs-1 mb-2"></i>
                        @lang('No withdrawal methods are active right now.')
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
