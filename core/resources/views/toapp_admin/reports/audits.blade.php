@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-tabs">
    <a href="{{ route('toapp.admin.reports.transactions') }}">Transactions</a>
    <a href="{{ route('toapp.admin.reports.investments') }}">Investments</a>
    <a href="{{ route('toapp.admin.reports.logins') }}">Login History</a>
    <a class="active" href="{{ route('toapp.admin.reports.audits') }}">Audit Logs</a>
</section>

<section class="ta-panel">
    <div class="ta-panel-head">
        <div>
            <span class="ta-kicker">Admin trail</span>
            <h2>Operational audit log</h2>
        </div>
        <i class="las la-clipboard-check"></i>
    </div>

    <form class="ta-toolbar ta-toolbar-slim" method="GET">
        <label class="ta-field compact"><span>Search</span><input type="search" name="search" value="{{ request('search') }}" placeholder="action, admin, IP, target"></label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-filter"></i> Filter</button>
    </form>

    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead>
                <tr><th>Action</th><th>Admin</th><th>Target</th><th>Context</th><th>IP</th><th>Date</th></tr>
            </thead>
            <tbody>
                @forelse($audits as $audit)
                    <tr>
                        <td><strong>{{ $audit->action }}</strong><small>#{{ $audit->id }}</small></td>
                        <td><strong>{{ optional($audit->admin)->username ?? 'System' }}</strong><small>{{ optional($audit->admin)->email }}</small></td>
                        <td>{{ class_basename($audit->target_type ?? '-') }}<small>{{ $audit->target_id ? '#' . $audit->target_id : '-' }}</small></td>
                        <td>
                            @if($audit->metadata)
                                <code class="ta-inline-code">{{ json_encode($audit->metadata, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</code>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $audit->ip_address ?? '-' }}</td>
                        <td>{{ optional($audit->created_at)->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="ta-empty">No admin activity has been logged yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $audits->links() }}</div>
</section>
@endsection
