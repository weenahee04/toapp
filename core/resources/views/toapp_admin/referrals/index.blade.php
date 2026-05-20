@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-grid ta-grid-main">
    <article class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">Rules</span>
                <h2>Level percent by package</h2>
            </div>
            <i class="las la-sitemap"></i>
        </div>

        <form class="ta-plan-form" method="POST" action="{{ route('toapp.admin.referrals.rules.store') }}">
            @csrf
            <div class="ta-two-col">
                <label class="ta-field">
                    <span>Package</span>
                    <select name="plan_id">
                        <option value="">Global fallback</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="ta-field">
                    <span>Level</span>
                    <input type="number" name="level" min="1" max="20" value="1" required>
                </label>
                <label class="ta-field">
                    <span>Percent</span>
                    <input type="number" name="percent" min="0" max="100" step="0.01" placeholder="10.00" required>
                </label>
                <label class="ta-field">
                    <span>Status</span>
                    <select name="status">
                        <option value="1">Enabled</option>
                        <option value="0">Disabled</option>
                    </select>
                </label>
            </div>
            <button class="ta-primary-btn ta-fit-btn" type="submit">Save Rule</button>
        </form>

        <div class="ta-table-wrap">
            <table class="ta-table">
                <thead>
                    <tr><th>Package</th><th>Level</th><th>Percent</th><th>Status</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse($rules as $rule)
                        <tr>
                            <td><strong>{{ optional($rule->plan)->name ?? 'Global fallback' }}</strong><small>{{ $rule->commission_type }}</small></td>
                            <td>Level {{ $rule->level }}</td>
                            <td>{{ number_format((float) $rule->percent, 2) }}%</td>
                            <td><span class="ta-badge {{ $rule->status ? 'success' : 'muted' }}">{{ $rule->status ? 'Enabled' : 'Disabled' }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('toapp.admin.referrals.rules.destroy', $rule) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="ta-link-btn" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="ta-empty">No referral rules yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>

    <aside class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">How it pays</span>
                <h2>Commission logic</h2>
            </div>
        </div>
        <div class="ta-form-stack">
            <div class="ta-note-card"><strong>1. Package first</strong><span>If a package has rules, those rules are used for that purchase.</span></div>
            <div class="ta-note-card"><strong>2. Global fallback</strong><span>If the package has no custom rules, global rules are used.</span></div>
            <div class="ta-note-card"><strong>3. Ledger safe</strong><span>Each investment can pay each upline level only once.</span></div>
        </div>
    </aside>
</section>

<section class="ta-panel">
    <div class="ta-panel-head">
        <div>
            <span class="ta-kicker">Ledger</span>
            <h2>Referral commission payouts</h2>
        </div>
    </div>

    <form class="ta-toolbar" method="GET">
        <label class="ta-field compact"><span>Search</span><input type="search" name="search" value="{{ request('search') }}" placeholder="trx, earner, source"></label>
        <label class="ta-field compact"><span>Level</span><input type="number" name="level" min="1" value="{{ request('level') }}" placeholder="Any"></label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-filter"></i> Filter</button>
    </form>

    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead>
                <tr><th>TRX</th><th>Earner</th><th>From Member</th><th>Package</th><th>Level</th><th>Amount</th><th>Date</th></tr>
            </thead>
            <tbody>
                @forelse($commissions as $commission)
                    <tr>
                        <td><strong>{{ $commission->trx ?? '-' }}</strong><small>#{{ $commission->id }}</small></td>
                        <td><strong>{{ optional($commission->earner)->username ?? 'Unknown' }}</strong><small>{{ optional($commission->earner)->email }}</small></td>
                        <td><strong>{{ optional($commission->sourceUser)->username ?? 'Unknown' }}</strong><small>{{ optional($commission->sourceUser)->email }}</small></td>
                        <td>{{ optional($commission->plan)->name ?? '-' }}</td>
                        <td>Level {{ $commission->level }}<small>{{ number_format((float) $commission->percent, 2) }}%</small></td>
                        <td><span class="ta-money-plus">+{{ number_format((float) $commission->amount, 2) }}</span><small>base {{ number_format((float) $commission->base_amount, 2) }}</small></td>
                        <td>{{ optional($commission->paid_at ?? $commission->created_at)->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="ta-empty">No referral commissions paid yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $commissions->links() }}</div>
</section>
@endsection
