@extends($activeTemplate . 'layouts.master')

@section('content')
@php
    $initialLevel = optional($referrals->first())->level ?? 1;
@endphp
<div class="page">
    <div class="page-boxed">
        <header class="header">
            <a href="{{ route('user.home') }}" class="icons arrow-back"></a>
            <h2 class="fs-24">My Network</h2>
        </header>

        <div class="section">
            <h1 class="title-main text-primary fs-18">Total network : <span id="total-network">{{ $totalNetwork }}</span> Users</h1>

            <div class="row g-md-3 g-2">
                <div class="col-12">
                    <div class="dropdown form-select shawdow-0">
                        <a href="#" class="fw-500 selected" data-bs-toggle="dropdown" data-bs-display="static">
                            Level {{ $initialLevel }}
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($referrals as $referral)
                                <li data-level="{{ $referral->level }}" class="{{ $referral->level == $initialLevel ? 'active' : '' }}">Level {{ $referral->level }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-network">
                        <div class="card-body" id="level_users">
                            <h3 id="lvl-network"></h3>
                            <ul class="users-status" id="level-user-counts"></ul>
                        </div>

                        <div class="card-footer">
                            <ul class="users-status" id="total-reffered"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('script')
<script>
var $dropdownLevel = $(".dropdown-menu").find("li");
$dropdownLevel.on('click',function(){
      const level = $(this).data('level');
      $('.dropdown-menu li').removeClass('active');
      $(this).addClass('active');
      $('.selected').text(`Level ${level}`);
      levelStatusShow(level);
 })

const initialLevel = Number(@json($initialLevel));
levelStatusShow(initialLevel);

function levelSkeleton(repeat=1){
    let loading=``;
    for(let i = 0 ; i < repeat;i++){
        loading+=`<div class="d-flex justify-content-between w-100"><span class="skeleton skeleton-text-box w-50"></span> <span class="skeleton skeleton-text-box w-25"></span></div>`;
    }
    return  loading;
}

function levelStatusShow(level){

    let levelNetwork = $('#lvl-network');
    let levelStatus =  $('#level-user-counts');
    let levelTotal  = $('#total-reffered');
    let totalNetwork = $('#total-network');

    levelNetwork.html(`Network Level ${level}`);
    levelStatus.html(levelSkeleton(2));
    levelTotal.html(levelSkeleton());

    $.ajax({
    url:"{{route('user.level.count')}}",
    method:"post",
    data:{
        _token:"{{csrf_token()}}",
        level:level,
    },
    success:function(data){
        const levelData = data.levels.find((l)=>l.level==level);
        totalNetwork.html(data.total_network);
        levelStatus.html(levelStatusCount(levelData));
        levelTotal.html(LeveltotalStatusCount(levelData));
    },
    error:function(xhr){
        notify('error',xhr.responseJSON.error)
    }
    })

 }

 function levelStatusCount(levelData){
    return `<li class="inactive" ><strong>Inactive users</strong><span>${levelData?.inactive_count ?? 0}</span></li>
    <li class="active"><strong>Active users</strong><span>${levelData?.active_count ?? 0}</span></li>`;
 }

 function LeveltotalStatusCount(levelData){
    const active = parseInt(levelData?.active_count ?? 0);
    const inactive = parseInt(levelData?.inactive_count ?? 0);
    return `<li class="total"><strong>Total referred</strong><span>${active + inactive}</span></li>`;
 }
</script>
@endpush
