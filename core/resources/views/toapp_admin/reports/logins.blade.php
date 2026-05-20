@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-tabs">
    <a href="{{ route('toapp.admin.reports.transactions') }}">Transactions</a>
    <a href="{{ route('toapp.admin.reports.investments') }}">Investments</a>
    <a class="active" href="{{ route('toapp.admin.reports.logins') }}">Login History</a>
    <a href="{{ route('toapp.admin.reports.audits') }}">Audit Logs</a>
</section>

<section class="ta-panel">
    <form class="ta-toolbar" method="GET">
        <label class="ta-field compact"><span>Search</span><input type="search" name="search" value="{{ request('search') }}" placeholder="username, IP, city, country"></label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-filter"></i> Filter</button>
    </form>
    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead><tr><th>User</th><th>IP</th><th>Location</th><th>Device</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($logins as $login)
                    <tr>
                        <td><strong>{{ optional($login->user)->username ?? 'Unknown' }}</strong><small>{{ optional($login->user)->email }}</small></td>
                        <td>{{ $login->user_ip ?? '-' }}</td>
                        <td>{{ trim(($login->city ?? '') . ', ' . ($login->country ?? ''), ', ') ?: '-' }}<small>{{ $login->country_code }}</small></td>
                        <td>{{ $login->browser ?? '-' }}<small>{{ $login->os ?? '-' }}</small></td>
                        <td>{{ optional($login->created_at)->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="ta-empty">No login history found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $logins->links() }}</div>
</section>
@endsection
