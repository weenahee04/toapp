@extends($activeTemplate . 'layouts.app')
@include($activeTemplate . 'partials.user_ui')
@section('panel')
  
    <div class="main-wrapper">
        
        @yield('content')
    </div>
    <x-logout-confirmation />
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });
            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                        colum.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });
        })(jQuery);
    </script>
@endpush
