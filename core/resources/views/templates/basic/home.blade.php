@extends($activeTemplate . 'layouts.frontend')

@push('style-lib')
    <link rel="shortcut icon" href="{{ asset('assets/images/logo_icon/favicon.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('assets/images/logo_icon/favicon.png') }}" type="image/png">
@endpush

@push('style')
    <style>
        .box {
            width: 100%;
            height: 50px;
            flex-shrink: 0;
            border-radius: 8px;
            background: #fff;
            border: none;
            box-shadow: 2px 1px 8px 2px rgba(128, 206, 255, 0.4);
        }

        .label {
            color: var(--black, #1e1e1e);
            font-family: Poppins, sans-serif;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
        }

        .center {
            text-align: center;
        }

        @media all and (orientation: portrait) {
            body {
                background: url("{{ asset('assets/global/img/tablet-ver.png') }}") lightgray 50% / cover no-repeat;
                background-size: 100% auto;
                background-position: top;
            }

            .page-boxed {
                background-color: transparent !important;
            }
        }

        @media all and (orientation: landscape) {
            body {
                background: url("{{ asset('assets/global/img/bg-app-desktop.png') }}") lightgray 50% / cover no-repeat;
                background-size: 100% auto;
                background-position: top;
            }

            .page-boxed {
                background-color: transparent !important;
            }
        }

        .btnLogin {
            border-radius: 8px;
            border: 1px solid var(--light-blue, #18abcf);
            background: #fff;
            color: var(--dark--head, #015086);
            font-family: Poppins, sans-serif;
            font-size: 18px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            width: 250px !important;
            height: 60px;
            margin-left: auto;
            margin-right: auto;
            flex-shrink: 0 !important;
        }

        .btnRegister {
            border-radius: 8px;
            width: 250px !important;
            margin-top: 40px !important;
            height: 60px;
            margin-left: auto;
            margin-right: auto;
            flex-shrink: 0 !important;
            border: 1px solid var(--light-blue, #18abcf);
            background: var(--light-blue, linear-gradient(180deg, #18abcf 0%, #1e84f4 100%));
            color: var(--white, #fff);
            font-family: Poppins, sans-serif;
            font-size: 18px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
        }
    </style>
@endpush

@section('content')
    <div class="page-boxed bg">
        <div style="margin-top:-80px;text-align:center;">
            <span style="color:var(--black, #1E1E1E);text-align:center;text-shadow:0 1px 1px rgba(0, 0, 0, 0.25);font-family:Poppins, sans-serif;font-size:24px;font-style:normal;font-weight:600;line-height:normal;">
                Get started
            </span>
            <span style="background:var(--light-blue, linear-gradient(180deg, #18ABCF 0%, #1E84F4 100%));background-clip:text;-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-family:Poppins, sans-serif;font-size:24px;font-style:italic;font-weight:800;line-height:normal;">
                Together
            </span>
        </div>
        <div>
            <div style="padding:50px">
                <div style="padding-top:20px"></div>
                <div></div>
                <div style="margin-top:450px">
                    <div style="text-align:center;margin-top:-65px">
                        <img src="{{ asset('assets/global/img/tologo.png') }}" alt="To-app logo">
                    </div>
                    <div style="margin-top:40px">
                        <div class="row">
                            <button type="button" class="btnLogin" onclick="location.href='{{ route('user.login') }}';">
                                @lang('Login')
                            </button>
                        </div>
                        <div class="row text-center">
                            <button type="button" class="btnRegister" onclick="location.href='{{ route('user.register') }}';">
                                @lang('Create Account')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
