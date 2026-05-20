<aside class="ta-sidebar">
    @php($admin = auth('admin')->user())
    <a href="{{ route('toapp.admin.dashboard') }}" class="ta-brand">
        <span class="ta-brand-mark">T</span>
        <span>
            <strong>To-app</strong>
            <small>Control</small>
        </span>
    </a>

    <nav class="ta-nav">
        @if($admin?->canAccess('dashboard'))
            <a class="{{ request()->routeIs('toapp.admin.dashboard') ? 'active' : '' }}" href="{{ route('toapp.admin.dashboard') }}">
                <i class="las la-chart-pie"></i>
                <span>Dashboard</span>
            </a>
        @endif
        @if($admin?->canAccess('admins'))
            <a class="{{ request()->routeIs('toapp.admin.admins.*') ? 'active' : '' }}" href="{{ route('toapp.admin.admins.index') }}">
                <i class="las la-user-shield"></i>
                <span>Admins</span>
            </a>
        @endif
        @if($admin?->canAccess('users'))
            <a class="{{ request()->routeIs('toapp.admin.users.*') ? 'active' : '' }}" href="{{ route('toapp.admin.users.index') }}">
                <i class="las la-users"></i>
                <span>Users</span>
            </a>
        @endif
        @if($admin?->canAccess('plans'))
            <a class="{{ request()->routeIs('toapp.admin.plans.*') ? 'active' : '' }}" href="{{ route('toapp.admin.plans.index') }}">
                <i class="las la-layer-group"></i>
                <span>Plans</span>
            </a>
        @endif
        @if($admin?->canAccess('deposits'))
            <a class="{{ request()->routeIs('toapp.admin.deposits.*') ? 'active' : '' }}" href="{{ route('toapp.admin.deposits.index') }}">
                <i class="las la-wallet"></i>
                <span>Deposits</span>
            </a>
        @endif
        @if($admin?->canAccess('withdrawals'))
            <a class="{{ request()->routeIs('toapp.admin.withdrawals.*') ? 'active' : '' }}" href="{{ route('toapp.admin.withdrawals.index') }}">
                <i class="las la-university"></i>
                <span>Withdrawals</span>
            </a>
        @endif
        @if($admin?->canAccess('reports') || $admin?->canAccess('investments'))
            <a class="{{ request()->routeIs('toapp.admin.reports.*') ? 'active' : '' }}" href="{{ $admin?->canAccess('reports') ? route('toapp.admin.reports.transactions') : route('toapp.admin.reports.investments') }}">
                <i class="las la-chart-line"></i>
                <span>Reports</span>
            </a>
        @endif
        @if($admin?->canAccess('referrals'))
            <a class="{{ request()->routeIs('toapp.admin.referrals.*') ? 'active' : '' }}" href="{{ route('toapp.admin.referrals.index') }}">
                <i class="las la-sitemap"></i>
                <span>Referrals</span>
            </a>
        @endif
        @if($admin?->canAccess('support'))
            <a class="{{ request()->routeIs('toapp.admin.support.*') ? 'active' : '' }}" href="{{ route('toapp.admin.support.index') }}">
                <i class="las la-headset"></i>
                <span>Support</span>
            </a>
        @endif
        @if($admin?->canAccess('methods'))
            <a class="{{ request()->routeIs('toapp.admin.methods.*') ? 'active' : '' }}" href="{{ route('toapp.admin.methods.index') }}">
                <i class="las la-credit-card"></i>
                <span>Methods</span>
            </a>
        @endif
        @if($admin?->canAccess('settings'))
            <a class="{{ request()->routeIs('toapp.admin.settings.*') ? 'active' : '' }}" href="{{ route('toapp.admin.settings.edit') }}">
                <i class="las la-cog"></i>
                <span>Settings</span>
            </a>
        @endif
        @if($admin?->canAccess('readiness'))
            <a class="{{ request()->routeIs('toapp.admin.readiness.*') ? 'active' : '' }}" href="{{ route('toapp.admin.readiness.index') }}">
                <i class="las la-rocket"></i>
                <span>Readiness</span>
            </a>
        @endif
    </nav>

    <div class="ta-sidebar-note">
        <span>Phase 4</span>
        <strong>Launch backend online</strong>
    </div>
</aside>
