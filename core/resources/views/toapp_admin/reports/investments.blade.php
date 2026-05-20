@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-tabs">
    <a href="{{ route('toapp.admin.reports.transactions') }}">Transactions</a>
    <a class="active" href="{{ route('toapp.admin.reports.investments') }}">Investments</a>
    <a href="{{ route('toapp.admin.reports.logins') }}">Login History</a>
    <a href="{{ route('toapp.admin.reports.audits') }}">Audit Logs</a>
</section>

<section class="ta-panel">
    <form class="ta-toolbar" method="GET">
        <label class="ta-field compact"><span>Search</span><input type="search" name="search" value="{{ request('search') }}" placeholder="trx, user, plan"></label>
        <label class="ta-field compact"><span>Status</span><select name="status"><option value="">Any</option><option value="2" @selected(request('status') === '2')>Running</option><option value="1" @selected(request('status') === '1')>Completed</option></select></label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-filter"></i> Filter</button>
    </form>
    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead><tr><th>Investment</th><th>User</th><th>Plan</th><th>Amount</th><th>Return</th><th>Status</th><th>Dates</th></tr></thead>
            <tbody>
                @forelse($investments as $investment)
                    <tr>
                        <td><strong>{{ $investment->trx ?? '-' }}</strong><small>#{{ $investment->id }}</small></td>
                        <td><strong>{{ optional($investment->user)->username ?? 'Unknown' }}</strong><small>{{ optional($investment->user)->email }}</small></td>
                        <td>{{ optional($investment->plan)->name ?? '-' }}</td>
                        <td>{{ number_format((float) $investment->amount, 2) }}</td>
                        <td>{{ number_format((float) $investment->interest_amount, 2) }}<small>{{ $investment->total_paid }}/{{ $investment->total_return }} paid</small></td>
                        <td><span class="ta-badge {{ $investment->status == 2 ? 'success' : 'muted' }}">{{ $investment->status == 2 ? 'Running' : 'Completed' }}</span></td>
                        <td><strong>{{ $investment->next_return_date ? \Carbon\Carbon::parse($investment->next_return_date)->format('M d, Y') : '-' }}</strong><small>expires {{ $investment->expire_date ? \Carbon\Carbon::parse($investment->expire_date)->format('M d, Y') : '-' }}</small></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="ta-empty">No investments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $investments->links() }}</div>
</section>
@endsection
