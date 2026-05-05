@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-panel">
    <form class="ta-toolbar" method="GET">
        <label class="ta-field compact"><span>Search</span><input type="search" name="search" value="{{ request('search') }}" placeholder="trx or username"></label>
        <label class="ta-field compact"><span>Status</span><select name="status"><option value="">Any</option><option value="1" @selected(request('status') === '1')>Approved</option><option value="2" @selected(request('status') === '2')>Pending</option><option value="3" @selected(request('status') === '3')>Rejected</option></select></label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-search"></i> Filter</button>
    </form>
    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead><tr><th>Transaction</th><th>User</th><th>Amount</th><th>Method</th><th>Receives</th><th>Status</th><th>Created</th><th></th></tr></thead>
            <tbody>
                @forelse($withdrawals as $withdrawal)
                    <tr>
                        <td><strong>{{ $withdrawal->trx }}</strong><small>#{{ $withdrawal->id }}</small></td>
                        <td><strong>{{ optional($withdrawal->user)->username ?? 'Unknown' }}</strong><small>{{ optional($withdrawal->user)->email }}</small></td>
                        <td>{{ number_format((float) $withdrawal->amount, 2) }}<small>charge {{ number_format((float) $withdrawal->charge, 2) }}</small></td>
                        <td>{{ optional($withdrawal->method)->name ?? '-' }}</td>
                        <td>{{ number_format((float) $withdrawal->final_amount, 2) }} {{ $withdrawal->currency }}</td>
                        <td><span class="ta-badge {{ $withdrawal->status == 1 ? 'success' : ($withdrawal->status == 3 ? 'danger' : 'muted') }}">{{ [1 => 'Approved', 2 => 'Pending', 3 => 'Rejected'][$withdrawal->status] ?? $withdrawal->status }}</span></td>
                        <td>{{ optional($withdrawal->created_at)->format('M d, Y H:i') }}</td>
                        <td><a class="ta-row-action" href="{{ route('toapp.admin.withdrawals.show', $withdrawal) }}">Review</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="ta-empty">No withdrawals found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $withdrawals->links() }}</div>
</section>
@endsection
