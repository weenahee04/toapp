@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-grid ta-grid-main">
    <article class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">Cash In</span>
                <h2>Deposit Gateways</h2>
            </div>
            <i class="las la-wallet"></i>
        </div>
        <div class="ta-method-list">
            @forelse($depositGateways as $gateway)
                @php
                    $currency = $gateway->singleCurrency;
                @endphp
                <details class="ta-method-card">
                    <summary>
                        <span><strong>{{ $gateway->name }}</strong><small>{{ $gateway->alias }} - code {{ $gateway->code }}</small></span>
                        <span class="ta-badge {{ $gateway->status ? 'success' : 'danger' }}">{{ $gateway->status ? 'Enabled' : 'Disabled' }}</span>
                    </summary>
                    <form class="ta-plan-form" method="POST" action="{{ route('toapp.admin.methods.deposit.update', $gateway) }}">
                        @csrf
                        @method('PUT')
                        <label class="ta-field"><span>Name</span><input name="name" value="{{ old('name', $gateway->name) }}" required></label>
                        <div class="ta-two-col">
                            <label class="ta-field"><span>Currency</span><input name="currency" value="{{ old('currency', $currency->currency ?? '') }}"></label>
                            <label class="ta-field"><span>Rate</span><input type="number" step="0.00000001" name="rate" value="{{ old('rate', $currency->rate ?? 1) }}"></label>
                            <label class="ta-field"><span>Min</span><input type="number" step="0.00000001" name="min_amount" value="{{ old('min_amount', $currency->min_amount ?? 0) }}"></label>
                            <label class="ta-field"><span>Max</span><input type="number" step="0.00000001" name="max_amount" value="{{ old('max_amount', $currency->max_amount ?? 0) }}"></label>
                            <label class="ta-field"><span>Fixed Charge</span><input type="number" step="0.00000001" name="fixed_charge" value="{{ old('fixed_charge', $currency->fixed_charge ?? 0) }}"></label>
                            <label class="ta-field"><span>Percent Charge</span><input type="number" step="0.01" name="percent_charge" value="{{ old('percent_charge', $currency->percent_charge ?? 0) }}"></label>
                        </div>
                        <label class="ta-field"><span>Instructions</span><textarea name="description">{{ old('description', $gateway->description) }}</textarea></label>
                        <button class="ta-primary-btn ta-fit-btn" type="submit">Save Gateway</button>
                    </form>
                    <form method="POST" action="{{ route('toapp.admin.methods.deposit.status', $gateway) }}">
                        @csrf
                        <button class="ta-secondary-btn" type="submit">{{ $gateway->status ? 'Disable' : 'Enable' }}</button>
                    </form>
                </details>
            @empty
                <div class="ta-empty">No deposit gateways found.</div>
            @endforelse
        </div>
    </article>

    <article class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">Cash Out</span>
                <h2>Withdrawal Methods</h2>
            </div>
            <i class="las la-university"></i>
        </div>
        <div class="ta-method-list">
            @forelse($withdrawMethods as $method)
                <details class="ta-method-card">
                    <summary>
                        <span><strong>{{ $method->name }}</strong><small>{{ $method->currency }} - rate {{ number_format((float) $method->rate, 4) }}</small></span>
                        <span class="ta-badge {{ $method->status ? 'success' : 'danger' }}">{{ $method->status ? 'Enabled' : 'Disabled' }}</span>
                    </summary>
                    <form class="ta-plan-form" method="POST" action="{{ route('toapp.admin.methods.withdraw.update', $method) }}">
                        @csrf
                        @method('PUT')
                        <label class="ta-field"><span>Name</span><input name="name" value="{{ old('name', $method->name) }}" required></label>
                        <div class="ta-two-col">
                            <label class="ta-field"><span>Currency</span><input name="currency" value="{{ old('currency', $method->currency) }}" required></label>
                            <label class="ta-field"><span>Rate</span><input type="number" step="0.00000001" name="rate" value="{{ old('rate', $method->rate) }}" required></label>
                            <label class="ta-field"><span>Min</span><input type="number" step="0.00000001" name="min_limit" value="{{ old('min_limit', $method->min_limit) }}" required></label>
                            <label class="ta-field"><span>Max</span><input type="number" step="0.00000001" name="max_limit" value="{{ old('max_limit', $method->max_limit) }}" required></label>
                            <label class="ta-field"><span>Fixed Charge</span><input type="number" step="0.00000001" name="fixed_charge" value="{{ old('fixed_charge', $method->fixed_charge) }}" required></label>
                            <label class="ta-field"><span>Percent Charge</span><input type="number" step="0.01" name="percent_charge" value="{{ old('percent_charge', $method->percent_charge) }}" required></label>
                        </div>
                        <label class="ta-field"><span>Instructions</span><textarea name="description">{{ old('description', $method->description) }}</textarea></label>
                        <button class="ta-primary-btn ta-fit-btn" type="submit">Save Method</button>
                    </form>
                    <form method="POST" action="{{ route('toapp.admin.methods.withdraw.status', $method) }}">
                        @csrf
                        <button class="ta-secondary-btn" type="submit">{{ $method->status ? 'Disable' : 'Enable' }}</button>
                    </form>
                </details>
            @empty
                <div class="ta-empty">No withdrawal methods found.</div>
            @endforelse
        </div>
    </article>
</section>
@endsection
