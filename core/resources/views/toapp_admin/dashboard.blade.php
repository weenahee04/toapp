@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-grid ta-grid-stats">
    <article class="ta-stat">
        <span>Total Users</span>
        <strong>{{ number_format($stats['users']) }}</strong>
        <small>{{ number_format($stats['active_users']) }} active</small>
    </article>
    <article class="ta-stat is-warning">
        <span>Pending Approval</span>
        <strong>{{ number_format($stats['pending_users']) }}</strong>
        <small>New members to review</small>
    </article>
    <article class="ta-stat">
        <span>Plans</span>
        <strong>{{ number_format($stats['plans']) }}</strong>
        <small>{{ number_format($stats['running_investments']) }} running investments</small>
    </article>
    <article class="ta-stat is-warning">
        <span>Pending Deposits</span>
        <strong>{{ number_format($stats['pending_deposits']) }}</strong>
        <small>{{ number_format($stats['total_deposited'], 2) }} total deposited</small>
    </article>
    <article class="ta-stat is-danger">
        <span>Pending Withdrawals</span>
        <strong>{{ number_format($stats['pending_withdrawals']) }}</strong>
        <small>{{ number_format($stats['total_withdrawn'], 2) }} total withdrawn</small>
    </article>
    <article class="ta-stat is-success">
        <span>Referral Paid</span>
        <strong>{{ number_format($stats['referral_paid'], 2) }}</strong>
        <small>Commission ledger</small>
    </article>
</section>

<section class="ta-grid ta-grid-main">
    <article class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">People</span>
                <h2>Latest Users</h2>
            </div>
            <i class="las la-users"></i>
        </div>
        <div class="ta-table-wrap">
            <table class="ta-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $user)
                        <tr>
                            <td>
                                <strong>{{ trim($user->firstname . ' ' . $user->lastname) ?: $user->username }}</strong>
                                <small>{{ '@' . $user->username }}</small>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="ta-badge {{ $user->status ? 'success' : 'danger' }}">{{ $user->status ? 'Active' : 'Banned' }}</span>
                                @php($approvalClass = $user->approval_status === 'approved' ? 'success' : ($user->approval_status === 'rejected' ? 'danger' : 'warning'))
                                <span class="ta-badge {{ $approvalClass }}">{{ ucfirst($user->approval_status ?? 'approved') }}</span>
                            </td>
                            <td>{{ optional($user->created_at)->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="ta-empty">No users yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>

    <article class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">Ledger</span>
                <h2>Recent Transactions</h2>
            </div>
            <i class="las la-receipt"></i>
        </div>
        <div class="ta-list">
            @forelse($recentTransactions as $trx)
                <div class="ta-list-row">
                    <div>
                        <strong>{{ $trx->trx ?? 'Transaction' }}</strong>
                        <small>{{ optional($trx->user)->username ?? 'System' }} - {{ optional($trx->created_at)->format('M d, H:i') }}</small>
                    </div>
                    <span class="{{ ($trx->trx_type ?? '+') === '+' ? 'ta-money-plus' : 'ta-money-minus' }}">
                        {{ $trx->trx_type ?? '' }}{{ number_format((float) $trx->amount, 2) }}
                    </span>
                </div>
            @empty
                <div class="ta-empty">No transactions yet.</div>
            @endforelse
        </div>
    </article>
</section>

<section class="ta-grid ta-grid-main">
    <article class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">Cash In</span>
                <h2>Latest Deposits</h2>
            </div>
            <i class="las la-wallet"></i>
        </div>
        <div class="ta-list">
            @forelse($recentDeposits as $deposit)
                <div class="ta-list-row">
                    <div>
                        <strong>{{ optional($deposit->user)->username ?? 'Unknown user' }}</strong>
                        <small>{{ $deposit->trx }} - {{ optional($deposit->created_at)->format('M d, H:i') }}</small>
                    </div>
                    <span>{{ number_format((float) $deposit->amount, 2) }}</span>
                </div>
            @empty
                <div class="ta-empty">No deposits yet.</div>
            @endforelse
        </div>
    </article>

    <article class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">Cash Out</span>
                <h2>Latest Withdrawals</h2>
            </div>
            <i class="las la-university"></i>
        </div>
        <div class="ta-list">
            @forelse($recentWithdrawals as $withdrawal)
                <div class="ta-list-row">
                    <div>
                        <strong>{{ optional($withdrawal->user)->username ?? 'Unknown user' }}</strong>
                        <small>{{ optional($withdrawal->method)->name ?? 'Method' }} - {{ optional($withdrawal->created_at)->format('M d, H:i') }}</small>
                    </div>
                    <span>{{ number_format((float) $withdrawal->amount, 2) }}</span>
                </div>
            @empty
                <div class="ta-empty">No withdrawals yet.</div>
            @endforelse
        </div>
    </article>
</section>
@endsection
