<?php

namespace App\Http\Controllers\ToappAdmin;

use App\Constants\Status;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($inner) use ($search) {
                    $inner->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->integer('status')))
            ->when($request->filled('kyc'), fn ($query) => $query->where('kv', $request->integer('kyc')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('toapp_admin.users.index', [
            'pageTitle' => 'Users',
            'users' => $users,
        ]);
    }

    public function show(User $user)
    {
        return view('toapp_admin.users.show', [
            'pageTitle' => 'User Detail',
            'user' => $user,
            'totalDeposit' => Deposit::where('user_id', $user->id)->successful()->sum('amount'),
            'totalWithdrawals' => Withdrawal::where('user_id', $user->id)->approved()->sum('amount'),
            'transactions' => Transaction::where('user_id', $user->id)->latest()->take(10)->get(),
        ]);
    }

    public function status(Request $request, User $user)
    {
        if ($user->status == Status::USER_ACTIVE) {
            $validated = $request->validate([
                'reason' => ['required', 'string', 'max:255'],
            ]);

            $user->status = Status::USER_BAN;
            $user->ban_reason = $validated['reason'];
            $message = 'User banned successfully.';
        } else {
            $user->status = Status::USER_ACTIVE;
            $user->ban_reason = null;
            $message = 'User restored successfully.';
        }

        $user->save();

        return back()->with('status', $message);
    }

    public function verification(Request $request, User $user)
    {
        $validated = $request->validate([
            'ev' => ['nullable', 'boolean'],
            'sv' => ['nullable', 'boolean'],
            'kv' => ['nullable', 'integer', 'in:0,1,2'],
        ]);

        $user->ev = (int) ($validated['ev'] ?? 0);
        $user->sv = (int) ($validated['sv'] ?? 0);
        $user->kv = (int) ($validated['kv'] ?? Status::KYC_UNVERIFIED);
        $user->save();

        return back()->with('status', 'Verification flags updated.');
    }

    public function balance(Request $request, User $user)
    {
        $validated = $request->validate([
            'act' => ['required', 'in:add,sub'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'remark' => ['required', 'string', 'max:255'],
        ]);

        $amount = (float) $validated['amount'];

        if ($validated['act'] === 'sub' && $amount > $user->balance) {
            return back()->withErrors(['amount' => 'This user does not have enough balance.']);
        }

        DB::transaction(function () use ($user, $amount, $validated) {
            $user->balance = $validated['act'] === 'add'
                ? $user->balance + $amount
                : $user->balance - $amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = $validated['act'] === 'add' ? '+' : '-';
            $transaction->remark = $validated['act'] === 'add' ? 'admin_balance_add' : 'admin_balance_subtract';
            $transaction->details = $validated['remark'];
            $transaction->trx = getTrx();
            $transaction->save();
        });

        return back()->with('status', 'Balance updated and ledger entry created.');
    }
}
