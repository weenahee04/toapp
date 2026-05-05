@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-panel">
    <form class="ta-toolbar" method="GET">
        <label class="ta-field compact"><span>Search</span><input type="search" name="search" value="{{ request('search') }}" placeholder="ticket, subject, name, email"></label>
        <label class="ta-field compact"><span>Status</span><select name="status"><option value="">Any</option><option value="0" @selected(request('status') === '0')>Open</option><option value="1" @selected(request('status') === '1')>Answered</option><option value="2" @selected(request('status') === '2')>Customer Reply</option><option value="3" @selected(request('status') === '3')>Closed</option></select></label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-filter"></i> Filter</button>
    </form>
    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead><tr><th>Ticket</th><th>Customer</th><th>Subject</th><th>Priority</th><th>Status</th><th>Last Reply</th><th></th></tr></thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td><strong>#{{ $ticket->ticket }}</strong><small>ID {{ $ticket->id }}</small></td>
                        <td><strong>{{ optional($ticket->user)->username ?? $ticket->name }}</strong><small>{{ $ticket->email }}</small></td>
                        <td>{{ $ticket->subject }}</td>
                        <td><span class="ta-badge {{ $ticket->priority == 3 ? 'danger' : 'muted' }}">{{ [1 => 'Low', 2 => 'Medium', 3 => 'High'][$ticket->priority] ?? 'Normal' }}</span></td>
                        <td><span class="ta-badge {{ $ticket->status == 3 ? 'muted' : ($ticket->status == 1 ? 'success' : 'danger') }}">{{ [0 => 'Open', 1 => 'Answered', 2 => 'Customer Reply', 3 => 'Closed'][$ticket->status] ?? $ticket->status }}</span></td>
                        <td>{{ $ticket->last_reply ? \Carbon\Carbon::parse($ticket->last_reply)->format('M d, Y H:i') : optional($ticket->updated_at)->format('M d, Y H:i') }}</td>
                        <td><a class="ta-row-action" href="{{ route('toapp.admin.support.show', $ticket) }}">Open</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="ta-empty">No support tickets found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $tickets->links() }}</div>
</section>
@endsection
