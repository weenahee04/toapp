<?php

namespace App\Http\Controllers\ToappAdmin;

use App\Constants\Status;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $withdrawals = Withdrawal::with(['user', 'method'])
            ->where('status', '!=', Status::PAYMENT_INITIATE)
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

        return view('toapp_admin.withdrawals.index', [
            'pageTitle' => 'Withdrawals',
            'withdrawals' => $withdrawals,
        ]);
    }

    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load(['user', 'method']);

        return view('toapp_admin.withdrawals.show', [
            'pageTitle' => 'Withdrawal Detail',
            'withdrawal' => $withdrawal,
        ]);
    }

    public function approve(Request $request, Withdrawal $withdrawal)
    {
        abort_unless($withdrawal->status == Status::PAYMENT_PENDING, 422);

        $validated = $request->validate([
            'details' => ['nullable', 'string', 'max:1000'],
        ]);

        $withdrawal->status = Status::PAYMENT_SUCCESS;
        $withdrawal->admin_feedback = $validated['details'] ?? null;
        $withdrawal->save();

        return back()->with('status', 'Withdrawal approved successfully.');
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        abort_unless($withdrawal->status == Status::PAYMENT_PENDING, 422);

        $validated = $request->validate([
            'details' => ['required', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($withdrawal, $validated) {
            $withdrawal->status = Status::PAYMENT_REJECT;
            $withdrawal->admin_feedback = $validated['details'];
            $withdrawal->save();

            $user = $withdrawal->user;
            $user->balance += $withdrawal->amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $withdrawal->user_id;
            $transaction->amount = $withdrawal->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->remark = 'withdraw_reject';
            $transaction->details = 'Refunded for withdrawal rejection';
            $transaction->trx = $withdrawal->trx;
            $transaction->save();
        });

        return back()->with('status', 'Withdrawal rejected and balance refunded.');
    }
}
