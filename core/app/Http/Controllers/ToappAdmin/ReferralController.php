<?php

namespace App\Http\Controllers\ToappAdmin;

use App\Constants\Status;
use App\Models\Plan;
use App\Models\Referral;
use App\Models\ReferralCommission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $rules = Referral::with('plan')
            ->whereIn('commission_type', ['package_commission', 'deposit_commission'])
            ->when($request->filled('plan_id'), function ($query) use ($request) {
                $request->plan_id === 'global'
                    ? $query->whereNull('plan_id')
                    : $query->where('plan_id', $request->integer('plan_id'));
            })
            ->orderByRaw('plan_id is not null')
            ->orderBy('plan_id')
            ->orderBy('level')
            ->get();

        $commissions = ReferralCommission::with(['earner', 'sourceUser', 'plan'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($inner) use ($search) {
                    $inner->where('trx', 'like', "%{$search}%")
                        ->orWhereHas('earner', fn ($user) => $user->where('username', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                        ->orWhereHas('sourceUser', fn ($user) => $user->where('username', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('level'), fn ($query) => $query->where('level', $request->integer('level')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('toapp_admin.referrals.index', [
            'pageTitle' => 'Referral System',
            'plans' => Plan::orderBy('name')->get(),
            'rules' => $rules,
            'commissions' => $commissions,
        ]);
    }

    public function storeRule(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => ['nullable', 'integer', 'exists:plans,id'],
            'level' => ['required', 'integer', 'min:1', 'max:20'],
            'percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['nullable', 'boolean'],
        ]);

        Referral::updateOrCreate(
            [
                'commission_type' => 'package_commission',
                'plan_id' => $validated['plan_id'] ?? null,
                'level' => $validated['level'],
            ],
            [
                'percent' => $validated['percent'],
                'status' => (int) ($validated['status'] ?? Status::DISABLE),
            ]
        );

        return back()->with('status', 'Referral rule saved successfully.');
    }

    public function destroyRule(Referral $referral)
    {
        $referral->delete();

        return back()->with('status', 'Referral rule deleted.');
    }
}
