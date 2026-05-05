@extends('toapp_admin.layouts.app')

@section('content')
<section class="ta-grid ta-grid-main">
    <article class="ta-panel">
        <div class="ta-panel-head">
            <div><span class="ta-kicker">Catalog</span><h2>Plan List</h2></div>
            <form class="ta-inline-search" method="GET">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search plans">
                <button type="submit"><i class="las la-search"></i></button>
            </form>
        </div>
        <div class="ta-table-wrap">
            <table class="ta-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Range</th>
                        <th>Return</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr>
                            <td><strong>{{ $plan->name }}</strong><small>{{ $plan->category ?: 'General' }}</small></td>
                            <td>{{ number_format((float) $plan->min_amount, 2) }} - {{ number_format((float) $plan->max_amount, 2) }}</td>
                            <td>{{ number_format((float) $plan->interest, 2) }}{{ $plan->interest_type == 1 ? '%' : '' }} x {{ $plan->total_return }}</td>
                            <td>{{ number_format((float) $plan->monthprice, 2) }} / {{ number_format((float) $plan->annualprice, 2) }}</td>
                            <td><span class="ta-badge {{ $plan->status ? 'success' : 'muted' }}">{{ $plan->status ? 'Enabled' : 'Disabled' }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('toapp.admin.plans.status', $plan) }}">
                                    @csrf
                                    <button class="ta-link-btn" type="submit">{{ $plan->status ? 'Disable' : 'Enable' }}</button>
                                </form>
                            </td>
                        </tr>
                        <tr class="ta-edit-row">
                            <td colspan="6">
                                <details>
                                    <summary>Edit {{ $plan->name }}</summary>
                                    @include('toapp_admin.plans.partials.form', ['plan' => $plan, 'action' => route('toapp.admin.plans.update', $plan), 'method' => 'PUT'])
                                </details>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="ta-empty">No plans found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="ta-pagination">{{ $plans->links() }}</div>
    </article>

    <article class="ta-panel">
        <div class="ta-panel-head"><div><span class="ta-kicker">Create</span><h2>New Plan</h2></div><i class="las la-layer-group"></i></div>
        <div class="ta-form-stack">
            @include('toapp_admin.plans.partials.form', ['plan' => null, 'action' => route('toapp.admin.plans.store'), 'method' => 'POST'])
        </div>
    </article>
</section>
@endsection
