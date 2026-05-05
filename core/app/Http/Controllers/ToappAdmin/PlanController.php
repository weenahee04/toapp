<?php

namespace App\Http\Controllers\ToappAdmin;

use App\Constants\Status;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = Plan::query()
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('toapp_admin.plans.index', [
            'pageTitle' => 'Plans',
            'plans' => $plans,
        ]);
    }

    public function store(Request $request)
    {
        $plan = new Plan();
        $this->savePlan($request, $plan);

        return back()->with('status', 'Plan created successfully.');
    }

    public function update(Request $request, Plan $plan)
    {
        $this->savePlan($request, $plan);

        return back()->with('status', 'Plan updated successfully.');
    }

    public function status(Plan $plan)
    {
        $plan->status = $plan->status == Status::ENABLE ? Status::DISABLE : Status::ENABLE;
        $plan->save();

        return back()->with('status', 'Plan status updated.');
    }

    private function savePlan(Request $request, Plan $plan): void
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'min_amount' => ['required', 'numeric', 'gt:0'],
            'max_amount' => ['required', 'numeric', 'gt:min_amount'],
            'total_return' => ['required', 'integer', 'gt:0'],
            'interest_type' => ['required', 'in:1,2'],
            'interest' => ['required', 'numeric', 'gt:0'],
            'descript' => ['nullable', 'string', 'max:250'],
            'category' => ['nullable', 'string', 'max:250'],
            'term' => ['nullable', 'string', 'max:2000'],
            'monthprice' => ['nullable', 'numeric', 'min:0'],
            'annualprice' => ['nullable', 'numeric', 'min:0'],
        ]);

        foreach ($validated as $key => $value) {
            $plan->{$key} = $value ?? '';
        }

        $plan->descript = $validated['descript'] ?? '';
        $plan->category = $validated['category'] ?? '';
        $plan->term = $validated['term'] ?? '';
        $plan->monthprice = $validated['monthprice'] ?? 0;
        $plan->annualprice = $validated['annualprice'] ?? 0;
        foreach (['monthprice1', 'monthprice2', 'monthprice3', 'monthprice4', 'monthprice5', 'monthprice6', 'monthprice7', 'monthprice8', 'annualprice1', 'annualprice2', 'annualprice3', 'annualprice4', 'annualprice5', 'annualprice6', 'annualprice7', 'annualprice8'] as $priceColumn) {
            $plan->{$priceColumn} ??= 0;
        }
        foreach (['agefrom', 'ageto', 'health', 'nicotin', 'sex'] as $profileColumn) {
            $plan->{$profileColumn} ??= '';
        }
        $plan->status ??= Status::ENABLE;
        $plan->save();
    }
}
