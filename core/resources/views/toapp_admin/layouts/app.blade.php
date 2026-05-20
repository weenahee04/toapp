<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Admin' }} - To-app</title>
    <link rel="shortcut icon" type="image/png" href="{{ siteFavicon() }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin_new/css/app.css') }}">
</head>
<body class="ta-admin-body">
    @php
        $currentAdmin = auth('admin')->user();
    @endphp
    <div class="ta-shell">
        @include('toapp_admin.partials.sidebar')
        <main class="ta-main">
            <header class="ta-topbar">
                <div>
                    <span class="ta-kicker">To-app Admin</span>
                    <h1>{{ $pageTitle ?? 'Dashboard' }}</h1>
                </div>
                <div class="ta-topbar-actions">
                    <span class="ta-admin-chip">
                        <strong>{{ $currentAdmin->username ?? 'admin' }}</strong>
                        <small>{{ $currentAdmin?->roleLabel() ?? 'Admin' }}</small>
                    </span>
                    <form action="{{ route('toapp.admin.logout') }}" method="POST">
                        @csrf
                        <button class="ta-icon-btn" type="submit" title="Logout">
                            <i class="las la-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </header>

            @if(session('status'))
                <div class="ta-alert ta-alert-success">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="ta-alert ta-alert-danger">{{ $errors->first() }}</div>
            @endif

            @yield('content')
        </main>
    </div>
    <script src="{{ asset('assets/global/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
