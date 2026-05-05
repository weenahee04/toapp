@extends($activeTemplate.'layouts.master')

@section('content')
<div class="page">
    <div class="page-boxed">
        <header class="header">
            <a href="{{ route('user.setting') }}" class="icons arrow-back"></a>

            <div class="d-flex gap-2">
                <img class="icons svg-js mb-auto" src="{{ asset('assets/global/img/icons/icon-setting-2.svg')}}" alt="">
                <div>
                    <p class="fs-18">Settings</p>
                    <p class="fs-14">Withdraw Methods</p>
                </div>
            </div>
        </header>

        <div class="section py-4">
            <div class="user-group">
                <img class="icons avatar" src="{{ asset('assets/global/img/thumb/avatar--1.png')}}" alt="">
                <h5>{{ $user->firstname }} {{ $user->lastname }}</h5>
            </div>

            <div class="boxed px-2 mt-sm-4 mt-3">
                <div class="px-3 pt-3">
                    <p class="mb-2">Withdraw destination details are collected when you submit a withdrawal request.</p>
                    <p class="text-muted mb-0">Available methods and limits are listed below.</p>
                </div>

                <div class="d-block px-3 py-3">
                    <div class="row g-3">
                        @forelse ($withdrawMethods as $method)
                            <div class="col-12">
                                <div class="card card-column h-100">
                                    <div class="infos-row">
                                        <p><small>{{ $method->name }}</small></p>
                                        <img class="icons ms-auto" src="{{ asset('assets/global/img/icons/icon-wallet.svg') }}" alt="">
                                    </div>

                                    <h4 class="fs-12-10 mb-2">{{ $method->currency }}</h4>
                                    <p class="mb-1">Limit: {{ showAmount($method->min_limit) }} - {{ showAmount($method->max_limit) }}</p>
                                    <p class="mb-0 text-muted">Charge: {{ showAmount($method->fixed_charge) }} + {{ showAmount($method->percent_charge, 2, false, false, false) }}%</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card card-column">
                                    <p class="mb-0 text-muted">No withdrawal methods are active right now.</p>
                                </div>
                            </div>
                        @endforelse

                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <a href="{{ route('user.withdraw.index') }}" class="btn btn-gradient w-100"><span>Start withdrawal</span></a>
                                <a href="{{ route('user.withdraw.history') }}" class="btn btn-outline-primary w-100"><span>Withdrawal history</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
