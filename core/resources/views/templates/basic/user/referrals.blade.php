@extends($activeTemplate . 'layouts.master')

@section('content')
@php
    $levels = $referrals->pluck('level')->unique()->sort()->values();
    $initialLevel = $levels->first() ?? 1;
@endphp
<div class="app-page app-network-page">
    <div class="app-container">
        <div class="app-topbar">
            <a class="app-icon-btn" href="{{ route('user.home') }}" aria-label="@lang('Back to dashboard')">
                <i class="las la-arrow-left"></i>
            </a>
            <a class="app-brand" href="{{ route('user.home') }}">
                <img src="{{ siteLogo() }}" alt="To-app">
                <span>@lang('My Network')</span>
            </a>
            <a class="app-icon-btn" href="{{ route('user.setting') }}" aria-label="@lang('Settings')">
                <i class="las la-cog"></i>
            </a>
        </div>

        <section class="app-hero app-network-hero">
            <span class="app-eyebrow"><i class="las la-sitemap"></i> @lang('Referral workspace')</span>
            <h1>@lang('Grow your member network with a clear link and clear rewards.')</h1>
            <p>@lang('Share your code, monitor each level, and review every commission credited from package purchases.')</p>

            <div class="app-copy-box app-network-copy">
                <input type="text" value="{{ $referralLink }}" id="referral-link" readonly>
                <button class="app-icon-btn" type="button" data-copy-value="{{ $referralLink }}" data-copy-message="@lang('Referral link copied')" aria-label="@lang('Copy referral link')">
                    <i class="las la-copy"></i>
                </button>
            </div>

            <div class="app-hero-actions">
                <button class="app-btn app-btn-primary" type="button" id="share-referral-link" data-link="{{ $referralLink }}">
                    <i class="las la-paper-plane"></i>
                    @lang('Share invite')
                </button>
                <button class="app-btn app-btn-secondary" type="button" data-copy-value="{{ $referralCode }}" data-copy-message="@lang('Referral code copied')">
                    <i class="las la-hashtag"></i>
                    {{ $referralCode }}
                </button>
            </div>
        </section>

        <div class="row app-grid mt-3">
            <div class="col-6 col-lg-3">
                <div class="app-stat" style="--tone: rgba(18, 104, 243, .12); --tone-color: #1268f3;">
                    <span class="app-stat-icon"><i class="las la-users"></i></span>
                    <label>@lang('Total network')</label>
                    <strong id="total-network">{{ $totalNetwork }}</strong>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="app-stat" style="--tone: rgba(22, 163, 74, .12); --tone-color: #16a34a;">
                    <span class="app-stat-icon"><i class="las la-coins"></i></span>
                    <label>@lang('Total earned')</label>
                    <strong>{{ showAmount($totalReferralCommission, 0) }}</strong>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="app-stat" style="--tone: rgba(20, 199, 214, .13); --tone-color: #0891b2;">
                    <span class="app-stat-icon"><i class="las la-calendar-week"></i></span>
                    <label>@lang('This month')</label>
                    <strong>{{ showAmount($monthlyReferralCommission, 0) }}</strong>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="app-stat" style="--tone: rgba(249, 115, 22, .12); --tone-color: #f97316;">
                    <span class="app-stat-icon"><i class="las la-layer-group"></i></span>
                    <label>@lang('Pay levels')</label>
                    <strong>{{ $levels->count() }}</strong>
                </div>
            </div>
        </div>

        <div class="row app-grid mt-1">
            <div class="col-lg-5">
                <div class="app-section-title">
                    <div>
                        <h2>@lang('Level overview')</h2>
                        <p>@lang('Choose a level to inspect active and inactive members.')</p>
                    </div>
                </div>

                <div class="app-card app-network-card">
                    <label class="app-field-label" for="network-level">@lang('Network level')</label>
                    <select class="app-form-control" id="network-level">
                        @forelse($levels as $level)
                            <option value="{{ $level }}" @selected($level == $initialLevel)>@lang('Level') {{ $level }}</option>
                        @empty
                            <option value="1">@lang('Level') 1</option>
                        @endforelse
                    </select>

                    <div class="app-network-ring mt-3">
                        <div>
                            <span id="lvl-network">@lang('Level') {{ $initialLevel }}</span>
                            <strong id="level-total">{{ optional($levelCounts->get($initialLevel))->total_count ?? 0 }}</strong>
                            <small>@lang('members in this level')</small>
                        </div>
                    </div>

                    <div class="app-network-split" id="level-user-counts">
                        @php($initialCounts = $levelCounts->get($initialLevel))
                        <div><span>@lang('Active')</span><strong>{{ optional($initialCounts)->active_count ?? 0 }}</strong></div>
                        <div><span>@lang('Inactive')</span><strong>{{ optional($initialCounts)->inactive_count ?? 0 }}</strong></div>
                    </div>
                </div>

                <div class="app-section-title">
                    <div>
                        <h2>@lang('Commission rules')</h2>
                        <p>@lang('Percent settings configured by admin.')</p>
                    </div>
                </div>

                <div class="app-list-card">
                    @forelse($referrals as $rule)
                        <div class="app-list-item">
                            <span class="app-list-icon"><i class="las la-percentage"></i></span>
                            <div class="app-list-body">
                                <strong>@lang('Level') {{ $rule->level }} - {{ number_format((float) $rule->percent, 2) }}%</strong>
                                <span>{{ optional($rule->plan)->name ?? __('Global fallback') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="app-empty-state">@lang('No commission rules are configured yet.')</div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-7">
                <div class="app-section-title">
                    <div>
                        <h2>@lang('Direct members')</h2>
                        <p>@lang('Newest members who joined with your referral code.')</p>
                    </div>
                </div>

                <div class="app-list-card">
                    @forelse($directReferrals as $member)
                        <div class="app-list-item">
                            <span class="app-list-icon"><i class="las la-user"></i></span>
                            <div class="app-list-body">
                                <strong>{{ $member->username }}</strong>
                                <span>{{ $member->email }} - {{ showDateTime($member->created_at, 'M d, Y') }}</span>
                            </div>
                            <span class="app-status-pill {{ $member->plan_id ? 'is-active' : 'is-muted' }}">
                                {{ $member->plan_id ? __('Active') : __('No plan') }}
                            </span>
                        </div>
                    @empty
                        <div class="app-empty-state">@lang('No direct members yet. Share your invite link to start building your network.')</div>
                    @endforelse
                </div>

                <div class="app-section-title">
                    <div>
                        <h2>@lang('Commission ledger')</h2>
                        <p>@lang('Every package commission credited to your account.')</p>
                    </div>
                </div>

                <div class="app-list-card">
                    @forelse($commissions as $commission)
                        <div class="app-list-item">
                            <span class="app-list-icon"><i class="las la-level-up-alt"></i></span>
                            <div class="app-list-body">
                                <strong>+{{ showAmount($commission->amount) }} - @lang('Level') {{ $commission->level }}</strong>
                                <span>{{ optional($commission->sourceUser)->username ?? __('Member') }} - {{ optional($commission->plan)->name ?? __('Package') }} - {{ optional($commission->created_at)->format('M d, Y H:i') }}</span>
                            </div>
                            <span class="app-amount is-plus">{{ number_format((float) $commission->percent, 2) }}%</span>
                        </div>
                    @empty
                        <div class="app-empty-state">@lang('No commission has been credited yet.')</div>
                    @endforelse
                </div>

                <div class="app-pagination mt-3">{{ $commissions->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function() {
        "use strict";

        const levelSelect = document.getElementById('network-level');
        const totalNetwork = document.getElementById('total-network');
        const levelTitle = document.getElementById('lvl-network');
        const levelTotal = document.getElementById('level-total');
        const levelCounts = document.getElementById('level-user-counts');
        const shareButton = document.getElementById('share-referral-link');

        levelSelect?.addEventListener('change', function() {
            levelStatusShow(this.value);
        });

        async function levelStatusShow(level) {
            levelTitle.textContent = `Level ${level}`;
            levelTotal.textContent = '...';
            levelCounts.innerHTML = '<div><span>Active</span><strong>...</strong></div><div><span>Inactive</span><strong>...</strong></div>';

            try {
                const response = await fetch("{{ route('user.level.count') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ level }),
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Network level load failed');

                const levelData = (data.levels || []).find((item) => Number(item.level) === Number(level)) || {};
                const active = Number(levelData.active_count || 0);
                const inactive = Number(levelData.inactive_count || 0);

                totalNetwork.textContent = data.total_network || 0;
                levelTotal.textContent = active + inactive;
                levelCounts.innerHTML = `<div><span>Active</span><strong>${active}</strong></div><div><span>Inactive</span><strong>${inactive}</strong></div>`;
            } catch (error) {
                notify('error', error.message);
            }
        }

        shareButton?.addEventListener('click', async function() {
            const link = this.dataset.link;

            if (navigator.share) {
                try {
                    await navigator.share({ title: document.title, url: link });
                    return;
                } catch (error) {}
            }

            await navigator.clipboard.writeText(link);
            notify('success', 'Referral link copied');
        });
    })();
</script>
@endpush
