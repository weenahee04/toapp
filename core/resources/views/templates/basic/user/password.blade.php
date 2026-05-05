@extends($activeTemplate.'layouts.master')

@section('content')
<div class="page">
    <div class="page-boxed">
        <header class="header">
            <a href="{{ route('user.setting') }}" class="icons arrow-back"></a>

            <div class="d-flex gap-2">
                <img class="icons svg-js mb-auto" src="{{ asset('assets/global/img/icons/icon-setting-2.svg')}}" alt="">
                <div>
                    <p class="fs-18">Settings</p>
                    <p class="fs-14">Change Password</p>
                </div>
            </div>
        </header>

        <div class="section py-4">
            <div class="user-group">
                <img class="icons avatar" src="{{ asset('assets/global/img/thumb/avatar--1.png')}}" alt="">
                <h5>{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h5>
            </div>

            <div class="boxed px-2 mt-sm-4 mt-3">
                <form action="{{ route('user.change.password') }}" method="post">
                    @csrf
                    <div class="d-block px-3">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group input__password">
                                    <label class="title">@lang('Current Password')<span class="star">*</span></label>
                                    <input type="password" id="password-toggle3" name="current_password" required autocomplete="current-password" class="form-control">
                                    <span class="input__password-label">
                                        <i class="fa fa-eye toggle-password3"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group input__password">
                                    <label class="title">@lang('New Password')<span class="star">*</span></label>
                                    <input type="password" id="password-toggle" name="password" required autocomplete="new-password" class="form-control @if (gs('secure_password')) secure-password @endif">
                                    <span class="input__password-label">
                                        <i class="fa fa-eye toggle-password"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group input__password">
                                    <label class="title">Confirm New Password<span class="star">*</span></label>
                                    <input type="password" id="password-toggleconfirm" name="password_confirmation" required autocomplete="new-password" class="form-control">
                                    <span class="input__password-label">
                                        <i class="fa fa-eye toggle-passwordconfirm"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-block px-3 mt-2">
                                    <button class="btn btn-gradient w-100"><span>Save</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="p-4"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .input__password {
        position: relative;
    }

    .input__password-label {
        position: absolute;
        top: 60%;
        right: 25px;
    }
</style>
@endpush

@if(gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
<script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#password-toggle");
        input.attr("type", input.attr("type") === "password" ? "text" : "password");
    });

    $(".toggle-passwordconfirm").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#password-toggleconfirm");
        input.attr("type", input.attr("type") === "password" ? "text" : "password");
    });

    $(".toggle-password3").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#password-toggle3");
        input.attr("type", input.attr("type") === "password" ? "text" : "password");
    });
</script>
@endpush
