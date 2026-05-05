@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-grid ta-grid-main">
    <article class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">Deploy Gate</span>
                <h2>{{ $readyCount }}/{{ count($checks) }} checks passing</h2>
            </div>
            <i class="las la-rocket"></i>
        </div>
        <div class="ta-readiness">
            @foreach($checks as $check)
                <div class="ta-check-row {{ $check['ok'] ? 'ok' : 'fail' }}">
                    <i class="las {{ $check['ok'] ? 'la-check-circle' : 'la-exclamation-circle' }}"></i>
                    <div>
                        <strong>{{ $check['title'] }}</strong>
                        <small>{{ $check['detail'] }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </article>

    <aside class="ta-panel">
        <div class="ta-panel-head">
            <div>
                <span class="ta-kicker">Next Steps</span>
                <h2>Production checklist</h2>
            </div>
        </div>
        <div class="ta-form-stack">
            <div class="ta-note-card"><strong>1. Set real environment</strong><span>Update domain, database, mail, and payment keys in production env.</span></div>
            <div class="ta-note-card"><strong>2. Review money queues</strong><span>Approve or reject pending deposit and withdrawal requests before launch.</span></div>
            <div class="ta-note-card"><strong>3. Cache safely</strong><span>Run route/config/view cache only after all routes are verified.</span></div>
            <div class="ta-note-card"><strong>4. Keep old admin off</strong><span>Use /admin-new as the clean backend while we replace old Envato screens.</span></div>
        </div>
    </aside>
</section>
@endsection
