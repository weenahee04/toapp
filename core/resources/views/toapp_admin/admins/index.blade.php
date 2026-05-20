@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-grid ta-grid-main">
    <article class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">Access control</span>
                <h2>Create Admin</h2>
            </div>
            <i class="las la-user-plus"></i>
        </div>
        <form class="ta-form-stack" method="POST" action="{{ route('toapp.admin.admins.store') }}">
            @csrf
            <div class="ta-two-col">
                <label class="ta-field"><span>Name</span><input name="name" value="{{ old('name') }}" required maxlength="80" placeholder="Finance Manager"></label>
                <label class="ta-field"><span>Email</span><input name="email" type="email" value="{{ old('email') }}" required maxlength="255" placeholder="finance@toapp.com"></label>
            </div>
            <div class="ta-two-col">
                <label class="ta-field"><span>Username</span><input name="username" value="{{ old('username') }}" required maxlength="80" placeholder="finance01"></label>
                <label class="ta-field"><span>Password</span><input name="password" type="password" required minlength="8" placeholder="At least 8 characters"></label>
            </div>
            <div class="ta-two-col">
                <label class="ta-field">
                    <span>Role preset</span>
                    <select name="role" required>
                        @foreach($roles as $value => $label)
                            <option value="{{ $value }}" @selected(old('role') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="ta-check ta-check-card">
                    <input type="checkbox" name="status" value="1" checked>
                    Active admin account
                </label>
            </div>
            <div class="ta-permission-grid">
                @foreach($permissions as $value => $label)
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $value }}">
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            <button class="ta-primary-btn ta-fit-btn" type="submit">Create Admin</button>
        </form>
    </article>

    <article class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">Role guide</span>
                <h2>Recommended Teams</h2>
            </div>
            <i class="las la-compass"></i>
        </div>
        <div class="ta-list">
            <div class="ta-list-row"><div><strong>Super Admin</strong><small>Full owner access. Keep this for trusted operators only.</small></div><span>All</span></div>
            <div class="ta-list-row"><div><strong>Operations</strong><small>Members, packages, referral reports, support and readiness.</small></div><span>Ops</span></div>
            <div class="ta-list-row"><div><strong>Finance</strong><small>Deposit, withdrawal, package approval, balance adjustment and reports.</small></div><span>Money</span></div>
            <div class="ta-list-row"><div><strong>Support</strong><small>Help desk and member review without money controls.</small></div><span>Care</span></div>
            <div class="ta-list-row"><div><strong>Viewer</strong><small>Read-only dashboard/reports for owner review.</small></div><span>Read</span></div>
        </div>
    </article>
</section>

<section class="ta-panel">
    <form class="ta-toolbar ta-toolbar-slim" method="GET">
        <label class="ta-field compact">
            <span>Search admins</span>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="name, username, email">
        </label>
        <button class="ta-secondary-btn" type="submit"><i class="las la-search"></i> Filter</button>
    </form>

    <div class="ta-table-wrap">
        <table class="ta-table">
            <thead>
                <tr>
                    <th>Admin</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Permissions</th>
                    <th>Updated</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td>
                            <strong>{{ $admin->name ?: $admin->username }}</strong>
                            <small>{{ '@' . $admin->username }} - {{ $admin->email }}</small>
                        </td>
                        <td><span class="ta-badge {{ $admin->role === 'super_admin' ? 'success' : 'muted' }}">{{ $admin->roleLabel() }}</span></td>
                        <td><span class="ta-badge {{ (int) $admin->status === 1 ? 'success' : 'danger' }}">{{ (int) $admin->status === 1 ? 'Active' : 'Disabled' }}</span></td>
                        <td><small>{{ implode(', ', $admin->permissions ?: []) ?: 'Role preset only' }}</small></td>
                        <td>{{ optional($admin->updated_at)->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr class="ta-edit-row">
                        <td colspan="5">
                            <details>
                                <summary>Edit {{ $admin->username }}</summary>
                                <form class="ta-plan-form" method="POST" action="{{ route('toapp.admin.admins.update', $admin) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="ta-two-col">
                                        <label class="ta-field"><span>Name</span><input name="name" value="{{ old('name', $admin->name) }}" required maxlength="80"></label>
                                        <label class="ta-field"><span>Email</span><input name="email" type="email" value="{{ old('email', $admin->email) }}" required maxlength="255"></label>
                                    </div>
                                    <div class="ta-two-col">
                                        <label class="ta-field"><span>Username</span><input name="username" value="{{ old('username', $admin->username) }}" required maxlength="80"></label>
                                        <label class="ta-field"><span>New password</span><input name="password" type="password" minlength="8" placeholder="Leave blank to keep current password"></label>
                                    </div>
                                    <div class="ta-two-col">
                                        <label class="ta-field">
                                            <span>Role preset</span>
                                            <select name="role" required>
                                                @foreach($roles as $value => $label)
                                                    <option value="{{ $value }}" @selected(old('role', $admin->role) === $value)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label class="ta-check ta-check-card">
                                            <input type="checkbox" name="status" value="1" @checked((int) $admin->status === 1)>
                                            Active admin account
                                        </label>
                                    </div>
                                    <div class="ta-permission-grid">
                                        @foreach($permissions as $value => $label)
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="{{ $value }}" @checked(in_array($value, $admin->permissions ?: [], true))>
                                                <span>{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <button class="ta-secondary-btn ta-fit-btn" type="submit">Save Admin</button>
                                </form>
                            </details>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="ta-empty">No admin accounts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="ta-pagination">{{ $admins->links() }}</div>
</section>
@endsection
