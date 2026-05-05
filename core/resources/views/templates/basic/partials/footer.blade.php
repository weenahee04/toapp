@php
    $footerItems = [
        [
            'label' => 'Dashboard',
            'route' => route('user.home'),
            'icon' => 'assets/global/img/icons/icon-dashboard.svg',
            'active' => request()->routeIs('user.home'),
        ],
        [
            'label' => 'Plans',
            'route' => route('user.plans'),
            'icon' => 'assets/global/img/icons/icon-shield-check.svg',
            'active' => request()->routeIs('user.plans', 'user.investment.log'),
        ],
        [
            'label' => 'Withdraw',
            'route' => route('user.withdraw.index'),
            'icon' => 'assets/global/img/icons/icon-wallet.svg',
            'active' => request()->routeIs('user.withdraw.*'),
        ],
        [
            'label' => 'Setting',
            'route' => route('user.setting'),
            'icon' => 'assets/global/img/icons/icon-setting.svg',
            'active' => request()->routeIs('user.setting', 'user.profile.setting', 'user.change.password', 'user.bank.setting', 'user.call', 'user.transactions', 'ticket.*'),
        ],
    ];
@endphp

<div class="footer-menu-block">
    <ul class="footer-menu">
        @foreach ($footerItems as $item)
            <li @class(['active' => $item['active']])>
                <a class="link-menu" href="{{ $item['route'] }}">
                    <img class="svg-js icons" src="{{ asset($item['icon']) }}" alt="{{ $item['label'] }}">
                    {{ $item['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
