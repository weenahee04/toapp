<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'approval_status')) {
                    $table->string('approval_status', 20)->default('approved')->after('status')->index();
                }
                if (!Schema::hasColumn('users', 'approved_at')) {
                    $table->timestamp('approved_at')->nullable()->after('approval_status');
                }
                if (!Schema::hasColumn('users', 'approved_by')) {
                    $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
                }
                if (!Schema::hasColumn('users', 'rejected_at')) {
                    $table->timestamp('rejected_at')->nullable()->after('approved_by');
                }
                if (!Schema::hasColumn('users', 'rejection_reason')) {
                    $table->text('rejection_reason')->nullable()->after('rejected_at');
                }
            });

            DB::table('users')
                ->whereNull('approval_status')
                ->orWhere('approval_status', '')
                ->update(['approval_status' => 'approved']);
        }

        if (Schema::hasTable('referrals')) {
            Schema::table('referrals', function (Blueprint $table) {
                if (!Schema::hasColumn('referrals', 'plan_id')) {
                    $table->unsignedBigInteger('plan_id')->nullable()->after('commission_type')->index();
                }
            });
        }

        if (!Schema::hasTable('referral_commissions')) {
            Schema::create('referral_commissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('earner_user_id')->index();
                $table->unsignedBigInteger('source_user_id')->index();
                $table->unsignedBigInteger('plan_id')->nullable()->index();
                $table->unsignedBigInteger('investment_id')->nullable()->index();
                $table->unsignedBigInteger('transaction_id')->nullable()->index();
                $table->unsignedInteger('level')->default(1);
                $table->decimal('base_amount', 28, 8)->default(0);
                $table->decimal('percent', 8, 4)->default(0);
                $table->decimal('amount', 28, 8)->default(0);
                $table->string('trx', 40)->nullable()->index();
                $table->string('status', 20)->default('paid')->index();
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();

                $table->unique(['investment_id', 'earner_user_id', 'level'], 'ref_comm_unique_investment_level');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_commissions');

        if (Schema::hasTable('referrals') && Schema::hasColumn('referrals', 'plan_id')) {
            Schema::table('referrals', function (Blueprint $table) {
                $table->dropColumn('plan_id');
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                foreach (['approval_status', 'approved_at', 'approved_by', 'rejected_at', 'rejection_reason'] as $column) {
                    if (Schema::hasColumn('users', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
