<aside class="ta-sidebar">
    <a href="{{ route('toapp.admin.dashboard') }}" class="ta-brand">
        <span class="ta-brand-mark">T</span>
        <span>
            <strong>To-app</strong>
            <small>Control</small>
        </span>
    </a>

    <nav class="ta-nav">
        <a class="{{ request()->routeIs('toapp.admin.dashboard') ? 'active' : '' }}" href="{{ route('toapp.admin.dashboard') }}">
            <i class="las la-chart-pie"></i>
            <span>Dashboard</span>
        </a>
        <a class="{{ request()->routeIs('toapp.admin.users.*') ? 'active' : '' }}" href="{{ route('toapp.admin.users.index') }}">
            <i class="las la-users"></i>
            <span>Users</span>
        </a>
        <a class="{{ request()->routeIs('toapp.admin.plans.*') ? 'active' : '' }}" href="{{ route('toapp.admin.plans.index') }}">
            <i class="las la-layer-group"></i>
            <span>Plans</span>
        </a>
        <a class="{{ request()->routeIs('toapp.admin.deposits.*') ? 'active' : '' }}" href="{{ route('toapp.admin.deposits.index') }}">
            <i class="las la-wallet"></i>
            <span>Deposits</span>
        </a>
        <a class="{{ request()->routeIs('toapp.admin.withdrawals.*') ? 'active' : '' }}" href="{{ route('toapp.admin.withdrawals.index') }}">
            <i class="las la-university"></i>
            <span>Withdrawals</span>
        </a>
        <a class="{{ request()->routeIs('toapp.admin.reports.*') ? 'active' : '' }}" href="{{ route('toapp.admin.reports.transactions') }}">
            <i class="las la-chart-line"></i>
            <span>Reports</span>
        </a>
        <a class="{{ request()->routeIs('toapp.admin.support.*') ? 'active' : '' }}" href="{{ route('toapp.admin.support.index') }}">
            <i class="las la-headset"></i>
            <span>Support</span>
        </a>
        <a class="{{ request()->routeIs('toapp.admin.methods.*') ? 'active' : '' }}" href="{{ route('toapp.admin.methods.index') }}">
            <i class="las la-credit-card"></i>
            <span>Methods</span>
        </a>
        <a class="{{ request()->routeIs('toapp.admin.settings.*') ? 'active' : '' }}" href="{{ route('toapp.admin.settings.edit') }}">
            <i class="las la-cog"></i>
            <span>Settings</span>
        </a>
        <a class="{{ request()->routeIs('toapp.admin.readiness.*') ? 'active' : '' }}" href="{{ route('toapp.admin.readiness.index') }}">
            <i class="las la-rocket"></i>
            <span>Readiness</span>
        </a>
    </nav>

    <div class="ta-sidebar-note">
        <span>Phase 4</span>
        <strong>Launch backend online</strong>
    </div>
</aside>
