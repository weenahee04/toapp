<?php

namespace App\Http\Controllers\ToappAdmin;

use App\Constants\Status;
use App\Http\Controllers\Gateway\PaymentController;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        $deposits = Deposit::with(['user', 'gateway'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($inner) use ($search) {
                    $inner->where('trx', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($user) => $user->where('username', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->integer('status')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('toapp_admin.deposits.index', [
            'pageTitle' => 'Deposits',
            'deposits' => $deposits,
        ]);
    }

    public function show(Deposit $deposit)
    {
        $deposit->load(['user', 'gateway']);

        return view('toapp_admin.deposits.show', [
            'pageTitle' => 'Deposit Detail',
            'deposit' => $deposit,
        ]);
    }

    public function approve(Deposit $deposit)
    {
        abort_unless($deposit->status == Status::PAYMENT_PENDING, 422);

        PaymentController::userDataUpdate($deposit, true);

        return back()->with('status', 'Deposit approved successfully.');
    }

    public function reject(Request $request, Deposit $deposit)
    {
        abort_unless($deposit->status == Status::PAYMENT_PENDING, 422);

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:255'],
        ]);

        $deposit->admin_feedback = $validated['message'];
        $deposit->status = Status::PAYMENT_REJECT;
        $deposit->save();

        return back()->with('status', 'Deposit rejected successfully.');
    }
}
