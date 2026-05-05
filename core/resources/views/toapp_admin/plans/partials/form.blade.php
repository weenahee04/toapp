<form method="POST" action="{{ $action }}" class="ta-plan-form">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif
    <label class="ta-field"><span>Name</span><input name="name" value="{{ old('name', $plan->name ?? '') }}" required maxlength="255"></label>
    <div class="ta-two-col">
        <label class="ta-field"><span>Min Amount</span><input name="min_amount" type="number" step="0.01" min="0.01" value="{{ old('min_amount', $plan->min_amount ?? '') }}" required></label>
        <label class="ta-field"><span>Max Amount</span><input name="max_amount" type="number" step="0.01" min="0.01" value="{{ old('max_amount', $plan->max_amount ?? '') }}" required></label>
    </div>
    <div class="ta-two-col">
        <label class="ta-field"><span>Interest Type</span><select name="interest_type"><option value="1" @selected(old('interest_type', $plan->interest_type ?? 1) == 1)>Percent</option><option value="2" @selected(old('interest_type', $plan->interest_type ?? 1) == 2)>Fixed</option></select></label>
        <label class="ta-field"><span>Interest</span><input name="interest" type="number" step="0.01" min="0.01" value="{{ old('interest', $plan->interest ?? '') }}" required></label>
    </div>
    <div class="ta-two-col">
        <label class="ta-field"><span>Total Return</span><input name="total_return" type="number" min="1" value="{{ old('total_return', $plan->total_return ?? 1) }}" required></label>
        <label class="ta-field"><span>Category</span><input name="category" value="{{ old('category', $plan->category ?? '') }}" maxlength="250"></label>
    </div>
    <div class="ta-two-col">
        <label class="ta-field"><span>Monthly Price</span><input name="monthprice" type="number" step="0.01" min="0" value="{{ old('monthprice', $plan->monthprice ?? 0) }}"></label>
        <label class="ta-field"><span>Annual Price</span><input name="annualprice" type="number" step="0.01" min="0" value="{{ old('annualprice', $plan->annualprice ?? 0) }}"></label>
    </div>
    <label class="ta-field"><span>Description</span><input name="descript" value="{{ old('descript', $plan->descript ?? '') }}" maxlength="250"></label>
    <label class="ta-field"><span>Terms</span><textarea name="term" rows="4">{{ old('term', $plan->term ?? '') }}</textarea></label>
    <button class="ta-primary-btn" type="submit">{{ $plan ? 'Save Plan' : 'Create Plan' }}</button>
</form>
