@extends('toapp_admin.layouts.app')

@section('content')
@php
    $admin = auth('admin')->user();
@endphp
<section class="ta-grid ta-grid-stats">
    <article class="ta-stat"><span>Balance</span><strong>{{ number_format((float) $user->balance, 2) }}</strong><small>Current wallet</small></article>
    <article class="ta-stat"><span>Total Deposit</span><strong>{{ number_format((float) $totalDeposit, 2) }}</strong><small>Successful only</small></article>
    <article class="ta-stat is-danger"><span>Total Withdraw</span><strong>{{ number_format((float) $totalWithdrawals, 2) }}</strong><small>Approved only</small></article>
    <article class="ta-stat is-warning"><span>Referral Earned</span><strong>{{ number_format((float) $totalReferralCommission, 2) }}</strong><small>{{ $directReferralCount }} direct referrals</small></article>
</section>

<section class="ta-grid ta-grid-main">
    <article class="ta-panel">
        <div class="ta-panel-head">
            <div><span class="ta-kicker">Profile</span><h2>{{ trim($user->firstname . ' ' . $user->lastname) ?: $user->username }}</h2></div>
            <a class="ta-row-action" href="{{ route('toapp.admin.users.index') }}">Back</a>
        </div>
        <div class="ta-detail-list">
            <div><span>Username</span><strong>{{ $user->username }}</strong></div>
            <div><span>Email</span><strong>{{ $user->email }}</strong></div>
            <div><span>Mobile</span><strong>{{ $user->dial_code }}{{ $user->mobile }}</strong></div>
            <div><span>Country</span><strong>{{ $user->country_name ?: '-' }}</strong></div>
            <div><span>Status</span><strong>{{ $user->status ? 'Active' : 'Banned' }}</strong></div>
            <div><span>Approval</span><strong>{{ ucfirst($user->approval_status ?? 'approved') }}</strong></div>
            <div><span>Referrer</span><strong>{{ $referrer?->username ?? '-' }}</strong></div>
            <div><span>Referral Code</span><strong>{{ $user->refno ?: '-' }}</strong></div>
            <div><span>Ban reason</span><strong>{{ $user->ban_reason ?: '-' }}</strong></div>
            @if($user->rejection_reason)
                <div><span>Reject reason</span><strong>{{ $user->rejection_reason }}</strong></div>
            @endif
        </div>
    </article>

    <article class="ta-panel">
        <div class="ta-panel-head"><div><span class="ta-kicker">Controls</span><h2>Account Actions</h2></div><i class="las la-user-shield"></i></div>
        <div class="ta-form-stack">
            @if(($user->approval_status ?? 'approved') !== 'approved')
                <form method="POST" action="{{ route('toapp.admin.users.approve', $user) }}">
                    @csrf
                    <button class="ta-primary-btn" type="submit">Approve Member</button>
                </form>
            @endif

            @if(($user->approval_status ?? 'approved') !== 'rejected')
                <form method="POST" action="{{ route('toapp.admin.users.reject', $user) }}">
                    @csrf
                    <label class="ta-field"><span>Reject reason</span><textarea name="reason" rows="3" required maxlength="1000" placeholder="Explain why this member cannot be approved yet"></textarea></label>
                    <button class="ta-danger-btn" type="submit">Reject Member</button>
                </form>
            @endif

            <form method="POST" action="{{ route('toapp.admin.users.verification', $user) }}">
                @csrf
                <div class="ta-toggle-row">
                    <label><input type="checkbox" name="ev" value="1" @checked($user->ev)> Email verified</label>
                    <label><input type="checkbox" name="sv" value="1" @checked($user->sv)> Mobile verified</label>
                </div>
                <label class="ta-field">
                    <span>KYC Status</span>
                    <select name="kv">
                        <option value="0" @selected($user->kv == 0)>Unverified</option>
                        <option value="1" @selected($user->kv == 1)>Verified</option>
                        <option value="2" @selected($user->kv == 2)>Pending</option>
                    </select>
                </label>
                <button class="ta-secondary-btn" type="submit">Save Verification</button>
            </form>

            <form method="POST" action="{{ route('toapp.admin.users.status', $user) }}">
                @csrf
                @if($user->status)
                    <label class="ta-field"><span>Ban reason</span><input name="reason" required maxlength="255" placeholder="Reason shown in admin notes"></label>
                    <button class="ta-danger-btn" type="submit">Ban User</button>
                @else
                    <button class="ta-primary-btn" type="submit">Restore User</button>
                @endif
            </form>

            @if($admin?->canAccess('balances'))
                <form method="POST" action="{{ route('toapp.admin.users.balance', $user) }}">
                    @csrf
                    <div class="ta-two-col">
                        <label class="ta-field"><span>Action</span><select name="act"><option value="add">Add</option><option value="sub">Subtract</option></select></label>
                        <label class="ta-field"><span>Amount</span><input name="amount" type="number" step="0.01" min="0.01" required></label>
                    </div>
                    <label class="ta-field"><span>Remark</span><input name="remark" required maxlength="255" placeholder="Why this adjustment is needed"></label>
                    <button class="ta-secondary-btn" type="submit">Update Balance</button>
                </form>
            @endif
        </div>
    </article>
</section>

<section class="ta-panel">
    <div class="ta-panel-head"><div><span class="ta-kicker">Ledger</span><h2>Recent Transactions</h2></div><i class="las la-receipt"></i></div>
    <div class="ta-list">
        @forelse($transactions as $trx)
            <div class="ta-list-row">
                <div><strong>{{ $trx->trx }}</strong><small>{{ $trx->details ?: $trx->remark }} - {{ optional($trx->created_at)->format('M d, H:i') }}</small></div>
                <span class="{{ $trx->trx_type === '+' ? 'ta-money-plus' : 'ta-money-minus' }}">{{ $trx->trx_type }}{{ number_format((float) $trx->amount, 2) }}</span>
            </div>
        @empty
            <div class="ta-empty">No transactions yet.</div>
        @endforelse
    </div>
</section>
@endsection
