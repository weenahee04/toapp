@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-panel">
    <form class="ta-toolbar" method="GET">
        <label class="ta-field compact"><span>Search</span><input type="search" name="search" value="{{ request('search') }}" placeholder="trx or username"></label>
        <label class="ta-field compact"><span>Status</span><select name="status"><option value="">Any</option><option value="0" @selected(request('status') === '0')>Initiated</option><option value="1" @selected(request('status') === '1')>Success</option><option value="2" @selected(request('status') === '2')>Pending</option><option value="3" @selected(request('status') === '3')>Rejected</option></select></label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-search"></i> Filter</button>
        <a class="ta-secondary-btn" href="{{ route('toapp.admin.deposits.export', request()->query()) }}"><i class="las la-file-csv"></i> Export CSV</a>
    </form>
    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead><tr><th>Transaction</th><th>User</th><th>Amount</th><th>Method</th><th>Status</th><th>Created</th><th></th></tr></thead>
            <tbody>
                @forelse($deposits as $deposit)
                    <tr>
                        <td><strong>{{ $deposit->trx }}</strong><small>#{{ $deposit->id }}</small></td>
                        <td><strong>{{ optional($deposit->user)->username ?? 'Unknown' }}</strong><small>{{ optional($deposit->user)->email }}</small></td>
                        <td>{{ number_format((float) $deposit->amount, 2) }}<small>charge {{ number_format((float) $deposit->charge, 2) }}</small></td>
                        <td>{{ optional($deposit->gateway)->name ?? $deposit->method_currency }}</td>
                        <td><span class="ta-badge {{ $deposit->status == 1 ? 'success' : ($deposit->status == 3 ? 'danger' : 'muted') }}">{{ ['Initiated','Success','Pending','Rejected'][$deposit->status] ?? $deposit->status }}</span></td>
                        <td>{{ optional($deposit->created_at)->format('M d, Y H:i') }}</td>
                        <td><a class="ta-row-action" href="{{ route('toapp.admin.deposits.show', $deposit) }}">Review</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="ta-empty">No deposits found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $deposits->links() }}</div>
</section>
@endsection
