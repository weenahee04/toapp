<?php

namespace App\Http\Controllers\ToappAdmin;

use App\Models\AdminAuditLog;
use App\Models\Investment;
use App\Models\Transaction;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportController extends Controller
{
    public function transactions(Request $request)
    {
        $remarks = Transaction::query()
            ->whereNotNull('remark')
            ->distinct()
            ->orderBy('remark')
            ->pluck('remark');

        $transactions = Transaction::with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($inner) use ($search) {
                    $inner->where('trx', 'like', "%{$search}%")
                        ->orWhere('details', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($user) => $user->where('username', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('trx_type'), fn ($query) => $query->where('trx_type', $request->trx_type))
            ->when($request->filled('remark'), fn ($query) => $query->where('remark', $request->remark))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('toapp_admin.reports.transactions', [
            'pageTitle' => 'Transaction Reports',
            'transactions' => $transactions,
            'remarks' => $remarks,
        ]);
    }

    public function investments(Request $request)
    {
        $investments = Investment::with(['user', 'plan'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($inner) use ($search) {
                    $inner->where('trx', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($user) => $user->where('username', 'like', "%{$search}%"))
                        ->orWhereHas('plan', fn ($plan) => $plan->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->integer('status')))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('toapp_admin.reports.investments', [
            'pageTitle' => 'Investment Reports',
            'investments' => $investments,
        ]);
    }

    public function logins(Request $request)
    {
        $logins = UserLogin::with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($inner) use ($search) {
                    $inner->where('user_ip', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($user) => $user->where('username', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('toapp_admin.reports.logins', [
            'pageTitle' => 'Login Reports',
            'logins' => $logins,
        ]);
    }

    public function audits(Request $request)
    {
        $audits = AdminAuditLog::with('admin')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($inner) use ($search) {
                    $inner->where('action', 'like', "%{$search}%")
                        ->orWhere('target_type', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%")
                        ->orWhereHas('admin', fn ($admin) => $admin->where('username', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('toapp_admin.reports.audits', [
            'pageTitle' => 'Admin Audit Logs',
            'audits' => $audits,
        ]);
    }
}
