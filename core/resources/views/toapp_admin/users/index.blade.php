@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-panel">
    <form class="ta-toolbar" method="GET">
        <label class="ta-field compact">
            <span>Search</span>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="username, email, name">
        </label>
        <label class="ta-field compact">
            <span>Status</span>
            <select name="status">
                <option value="">Any</option>
                <option value="1" @selected(request('status') === '1')>Active</option>
                <option value="0" @selected(request('status') === '0')>Banned</option>
            </select>
        </label>
        <label class="ta-field compact">
            <span>Approval</span>
            <select name="approval">
                <option value="">Any</option>
                <option value="pending" @selected(request('approval') === 'pending')>Pending</option>
                <option value="approved" @selected(request('approval') === 'approved')>Approved</option>
                <option value="rejected" @selected(request('approval') === 'rejected')>Rejected</option>
            </select>
        </label>
        <label class="ta-field compact">
            <span>KYC</span>
            <select name="kyc">
                <option value="">Any</option>
                <option value="0" @selected(request('kyc') === '0')>Unverified</option>
                <option value="1" @selected(request('kyc') === '1')>Verified</option>
                <option value="2" @selected(request('kyc') === '2')>Pending</option>
            </select>
        </label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-search"></i> Filter</button>
        <a class="ta-secondary-btn" href="{{ route('toapp.admin.users.export', request()->query()) }}"><i class="las la-file-csv"></i> Export CSV</a>
    </form>

    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Contact</th>
                    <th>Balance</th>
                    <th>Checks</th>
                    <th>Joined</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <strong>{{ trim($user->firstname . ' ' . $user->lastname) ?: $user->username }}</strong>
                            <small>{{ '@' . $user->username }}</small>
                        </td>
                        <td>
                            <strong>{{ $user->email }}</strong>
                            <small>{{ $user->dial_code }}{{ $user->mobile }}</small>
                        </td>
                        <td>{{ number_format((float) $user->balance, 2) }}</td>
                        <td>
                            <span class="ta-badge {{ $user->status ? 'success' : 'danger' }}">{{ $user->status ? 'Active' : 'Banned' }}</span>
                            @php($approvalClass = $user->approval_status === 'approved' ? 'success' : ($user->approval_status === 'rejected' ? 'danger' : 'warning'))
                            <span class="ta-badge {{ $approvalClass }}">{{ ucfirst($user->approval_status ?? 'approved') }}</span>
                            <span class="ta-badge {{ $user->kv == 1 ? 'success' : 'muted' }}">KYC {{ $user->kv == 1 ? 'OK' : ($user->kv == 2 ? 'Pending' : 'No') }}</span>
                        </td>
                        <td>{{ optional($user->created_at)->format('M d, Y') }}</td>
                        <td><a class="ta-row-action" href="{{ route('toapp.admin.users.show', $user) }}">Open</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="ta-empty">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $users->links() }}</div>
</section>
@endsection
