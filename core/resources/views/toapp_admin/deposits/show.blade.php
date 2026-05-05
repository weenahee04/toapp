@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-grid ta-grid-main">
    <article class="ta-panel">
        <div class="ta-panel-head"><div><span class="ta-kicker">Deposit</span><h2>{{ $deposit->trx }}</h2></div><a class="ta-row-action" href="{{ route('toapp.admin.deposits.index') }}">Back</a></div>
        <div class="ta-detail-list">
            <div><span>User</span><strong>{{ optional($deposit->user)->username ?? 'Unknown' }}</strong></div>
            <div><span>Amount</span><strong>{{ number_format((float) $deposit->amount, 2) }}</strong></div>
            <div><span>Charge</span><strong>{{ number_format((float) $deposit->charge, 2) }}</strong></div>
            <div><span>Final Amount</span><strong>{{ number_format((float) $deposit->final_amount, 2) }} {{ $deposit->method_currency }}</strong></div>
            <div><span>Status</span><strong>{{ ['Initiated','Success','Pending','Rejected'][$deposit->status] ?? $deposit->status }}</strong></div>
            <div><span>Feedback</span><strong>{{ $deposit->admin_feedback ?: '-' }}</strong></div>
        </div>
    </article>
    <article class="ta-panel">
        <div class="ta-panel-head"><div><span class="ta-kicker">Decision</span><h2>Review Request</h2></div><i class="las la-clipboard-check"></i></div>
        <div class="ta-form-stack">
            @if($deposit->status == \App\Constants\Status::PAYMENT_PENDING)
                <form method="POST" action="{{ route('toapp.admin.deposits.approve', $deposit) }}">@csrf<button class="ta-primary-btn" type="submit">Approve Deposit</button></form>
                <form method="POST" action="{{ route('toapp.admin.deposits.reject', $deposit) }}">
                    @csrf
                    <label class="ta-field"><span>Reject Message</span><textarea name="message" rows="4" required></textarea></label>
                    <button class="ta-danger-btn" type="submit">Reject Deposit</button>
                </form>
            @else
                <div class="ta-empty">This deposit is already finalized.</div>
            @endif
        </div>
    </article>
</section>
@endsection
