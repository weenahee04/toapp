@extends($activeTemplate.'layouts.frontend')

@section('content')
<div class="page">
    <div class="page-boxed">
        <header class="header">
            <a href="{{ route('user.setting') }}" class="icons arrow-back"></a>

            <div class="d-flex gap-2">
                <img class="icons svg-js" src="{{ asset('assets/global/img/icons/icon-setting-2.svg')}}" alt="">
                <div>
                    <p class="fs-18">Settings</p>
                    <p class="fs-14">Help & Support</p>
                </div>
            </div>
        </header>

        <div class="section py-4">
            <ul class="nav nav-links">
                <li>
                    <a href="{{ route('ticket.index') }}">
                        <img src="{{ asset('assets/global/img/icons/icon-users.svg')}}" style="width:45px" alt="">
                        My support tickets
                    </a>
                </li>
                <li>
                    <a href="{{ route('ticket.open') }}">
                        <img src="{{ asset('assets/global/img/icons/icon-dashboard.svg')}}" style="width:45px" alt="">
                        Open new ticket
                    </a>
                </li>
                <li>
                    <a href="tel:+1-725-2947734">
                        <img src="{{ asset('assets/global/img/icons/call.svg')}}" style="width:45px" alt="">
                        Call us
                    </a>
                </li>
                <li>
                    <a href="mailto:support@to-app.com">
                        <img src="{{ asset('assets/global/img/icons/mail.svg')}}" style="width:45px" alt="">
                        Send email
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
