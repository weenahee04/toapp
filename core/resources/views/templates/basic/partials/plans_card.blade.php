@php
    $plans = App\Models\Plan::where('status', Status::ENABLE)
        ->limit(12)
        ->orderBy('min_amount', 'ASC')
        ->get();
@endphp

@forelse($plans as $plan)
    <div class="col-xl-3 col-lg-4 col-sm-6 mb-4 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.2s">
        <article class="app-plan-card {{ $loop->first ? 'featured' : '' }}">
            <span class="app-plan-badge">
                <i class="las {{ $loop->first ? 'la-award' : 'la-shield-alt' }}"></i>
                {{ $loop->first ? __('Popular start') : __('Plan option') }}
            </span>

            <h4>{{ __($plan->name) }}</h4>
            <div class="app-plan-range">
                {{ showAmount($plan->min_amount, 0) }}
                -
                {{ showAmount($plan->max_amount, 0) }}
            </div>

            <div class="app-plan-return">
                <strong>
                    {{ showAmount($plan->interest, 0, currencyFormat: false) }}{{ $plan->interest_type == Status::FIXED ? '' : '%' }}
                </strong>
                <span>{{ $plan->interest_type == Status::FIXED ? gs('cur_text') : __('return') }}</span>
            </div>

            <ul class="app-feature-list">
                <li>
                    <i class="las la-check-circle"></i>
                    @lang('Return every day')
                </li>
                <li>
                    <i class="las la-check-circle"></i>
                    @lang('For') {{ $plan->total_return }} @lang('times')
                </li>
                <li>
                    <i class="las la-check-circle"></i>
                    @lang('Clear amount range')
                </li>
            </ul>

            <a href="#0" data-name="{{ __($plan->name) }}" data-id="{{ $plan->id }}" class="app-btn planModal" data-bs-toggle="modal"
                data-bs-target="{{ Auth::user() ? '#planModal' : '#loginModal' }}">
                <i class="las la-bolt"></i>
                @lang('Invest now')
            </a>
        </article>
    </div>
@empty
    <div class="col-12">
        <div class="app-empty-state">
            <i class="las la-box-open d-block fs-1 mb-2"></i>
            @lang('Plan does not found')
        </div>
    </div>
@endforelse

@auth
    @if ($plans->count() > 12)
        <div class="text-center">
            <a href="{{ route('user.plans') }}" class="app-btn app-btn-primary" data-wow-duration="0.5s" data-wow-delay="0.7s">@lang('View All')</a>
        </div>
    @endif
@endauth
