<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = auth()->user();
            if (in_array($user->approval_status, ['pending', 'rejected'], true)) {
                if ($request->is('api/*')) {
                    $notify[] = $user->approval_status === 'pending'
                        ? 'Your account is waiting for admin approval.'
                        : 'Your account was rejected. Please contact support.';

                    return response()->json([
                        'remark' => 'approval_required',
                        'status' => 'error',
                        'message' => ['error' => $notify],
                        'data' => ['user' => $user],
                    ], 403);
                }

                return to_route('user.approval.pending');
            }

            if (true) {
                return $next($request);
            } else {
                if ($request->is('api/*')) {
                    $notify[] = 'You need to verify your account first.';
                    return response()->json([
                        'remark'=>'unverified',
                        'status'=>'error',
                        'message'=>['error'=>$notify],
                        'data'=>[
                            'user'=>$user
                        ],
                    ]);
                }else{
                    return to_route('user.authorization');
                }
            }
        }
        abort(403);
    }
}
