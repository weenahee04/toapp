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
<body class="ta-auth-body">
    @yield('content')
    <script src="{{ asset('assets/global/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
