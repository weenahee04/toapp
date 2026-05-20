<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('admins', 'role')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('role', 40)->default('super_admin')->index();
            });
        }

        if (!Schema::hasColumn('admins', 'permissions')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->json('permissions')->nullable();
            });
        }

        if (!Schema::hasColumn('admins', 'status')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->boolean('status')->default(true)->index();
            });
        }

        DB::table('admins')
            ->whereNull('role')
            ->orWhere('role', '')
            ->update(['role' => 'super_admin']);
    }

    public function down(): void
    {
        if (Schema::hasColumn('admins', 'permissions')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('permissions');
            });
        }

        if (Schema::hasColumn('admins', 'role')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
