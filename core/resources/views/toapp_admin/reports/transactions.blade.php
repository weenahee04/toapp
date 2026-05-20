@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-tabs">
    <a class="active" href="{{ route('toapp.admin.reports.transactions') }}">Transactions</a>
    <a href="{{ route('toapp.admin.reports.investments') }}">Investments</a>
    <a href="{{ route('toapp.admin.reports.logins') }}">Login History</a>
    <a href="{{ route('toapp.admin.reports.audits') }}">Audit Logs</a>
</section>

<section class="ta-panel">
    <form class="ta-toolbar" method="GET">
        <label class="ta-field compact"><span>Search</span><input type="search" name="search" value="{{ request('search') }}" placeholder="trx, username, detail"></label>
        <label class="ta-field compact"><span>Type</span><select name="trx_type"><option value="">Any</option><option value="+" @selected(request('trx_type') === '+')>Credit</option><option value="-" @selected(request('trx_type') === '-')>Debit</option></select></label>
        <label class="ta-field compact"><span>Remark</span><select name="remark"><option value="">Any</option>@foreach($remarks as $remark)<option value="{{ $remark }}" @selected(request('remark') === $remark)>{{ $remark }}</option>@endforeach</select></label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-filter"></i> Filter</button>
    </form>
    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead><tr><th>TRX</th><th>User</th><th>Amount</th><th>Post Balance</th><th>Remark</th><th>Detail</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td><strong>{{ $trx->trx ?? '-' }}</strong><small>#{{ $trx->id }}</small></td>
                        <td><strong>{{ optional($trx->user)->username ?? 'System' }}</strong><small>{{ optional($trx->user)->email }}</small></td>
                        <td><span class="{{ $trx->trx_type === '-' ? 'ta-money-minus' : 'ta-money-plus' }}">{{ $trx->trx_type }}{{ number_format((float) $trx->amount, 2) }}</span><small>charge {{ number_format((float) $trx->charge, 2) }}</small></td>
                        <td>{{ number_format((float) $trx->post_balance, 2) }}</td>
                        <td>{{ $trx->remark ?? '-' }}</td>
                        <td>{{ $trx->details ?? '-' }}</td>
                        <td>{{ optional($trx->created_at)->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="ta-empty">No transactions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $transactions->links() }}</div>
</section>
@endsection
