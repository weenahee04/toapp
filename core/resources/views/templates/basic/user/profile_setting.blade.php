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
                    <p class="fs-14">Personal Information</p>
                </div>
            </div>
        </header>

        <div class="section py-4">
            <div class="user-group">
                <img class="icons avatar" src="{{ asset('assets/global/img/thumb/avatar--1.png')}}" alt="">
                <h5>{{ $user->firstname }} {{ $user->lastname }}</h5>
            </div>

            <div class="boxed px-2 mt-sm-4 mt-3">
                <form class="register" action="{{ route('user.profile.setting') }}" method="post">
                    @csrf
                    <div class="d-block px-3">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="title">First name <span class="star">*</span></label>
                                    <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="title">Last name <span class="star">*</span></label>
                                    <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="title">Email <span class="star">*</span></label>
                                    <input type="text" value="{{ $user->email }}" class="form-control" disabled>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="title">Phone number <span class="star">*</span></label>
                                    <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="title">Zip Code <span class="star">*</span></label>
                                    <input type="text" name="zipcode" value="{{ old('zipcode', $user->zipcode) }}" class="form-control">
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
