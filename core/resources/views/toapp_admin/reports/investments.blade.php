@extends('toapp_admin.layouts.app')

@section('content')
@php($admin = auth('admin')->user())
<section class="ta-tabs">
    @if($admin?->canAccess('reports'))
        <a href="{{ route('toapp.admin.reports.transactions') }}">Transactions</a>
    @endif
    <a class="active" href="{{ route('toapp.admin.reports.investments') }}">Investments</a>
    @if($admin?->canAccess('reports'))
        <a href="{{ route('toapp.admin.reports.logins') }}">Login History</a>
        <a href="{{ route('toapp.admin.reports.audits') }}">Audit Logs</a>
    @endif
</section>

<section class="ta-panel">
    <form class="ta-toolbar" method="GET">
        <label class="ta-field compact"><span>Search</span><input type="search" name="search" value="{{ request('search') }}" placeholder="trx, user, plan"></label>
        <label class="ta-field compact"><span>Status</span><select name="status"><option value="">Any</option><option value="0" @selected(request('status') === '0')>Pending</option><option value="2" @selected(request('status') === '2')>Running</option><option value="1" @selected(request('status') === '1')>Completed</option><option value="3" @selected(request('status') === '3')>Rejected</option></select></label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-filter"></i> Filter</button>
        <a class="ta-secondary-btn" href="{{ route('toapp.admin.reports.investments.export', request()->query()) }}"><i class="las la-file-csv"></i> Export CSV</a>
    </form>
    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead><tr><th>Investment</th><th>User</th><th>Plan</th><th>Amount</th><th>Return</th><th>Status</th><th>Dates</th><th>Action</th></tr></thead>
            <tbody>
                @forelse($investments as $investment)
                    @php
                        $statusClass = match ((int) $investment->status) {
                            0 => 'warning',
                            2 => 'success',
                            3 => 'danger',
                            default => 'muted',
                        };
                        $statusLabel = match ((int) $investment->status) {
                            0 => 'Pending',
                            2 => 'Running',
                            3 => 'Rejected',
                            default => 'Completed',
                        };
                    @endphp
                    <tr>
                        <td><strong>{{ $investment->trx ?? '-' }}</strong><small>#{{ $investment->id }}</small></td>
                        <td><strong>{{ optional($investment->user)->username ?? 'Unknown' }}</strong><small>{{ optional($investment->user)->email }}</small></td>
                        <td>{{ optional($investment->plan)->name ?? '-' }}</td>
                        <td>{{ number_format((float) $investment->amount, 2) }}</td>
                        <td>{{ number_format((float) $investment->interest_amount, 2) }}<small>{{ $investment->total_paid }}/{{ $investment->total_return }} paid</small></td>
                        <td><span class="ta-badge {{ $statusClass }}">{{ $statusLabel }}</span><small>{{ $investment->rejection_reason }}</small></td>
                        <td><strong>{{ $investment->next_return_date ? \Carbon\Carbon::parse($investment->next_return_date)->format('M d, Y') : '-' }}</strong><small>approved {{ $investment->approved_at ? $investment->approved_at->format('M d, Y') : '-' }}</small></td>
                        <td>
                            @if((int) $investment->status === 0 && $admin?->canAccess('investments'))
                                <div class="ta-action-stack">
                                    <form method="POST" action="{{ route('toapp.admin.reports.investments.approve', $investment) }}">
                                        @csrf
                                        <button class="ta-row-action" type="submit">Approve</button>
                                    </form>
                                    <details class="ta-mini-details">
                                        <summary>Reject</summary>
                                        <form method="POST" action="{{ route('toapp.admin.reports.investments.reject', $investment) }}">
                                            @csrf
                                            <label class="ta-field compact">
                                                <span>Reason</span>
                                                <textarea name="reason" required placeholder="Why is this package purchase rejected?"></textarea>
                                            </label>
                                            <button class="ta-danger-btn" type="submit">Reject & Refund</button>
                                        </form>
                                    </details>
                                </div>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="ta-empty">No investments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $investments->links() }}</div>
</section>
@endsection
