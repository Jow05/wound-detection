<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Cek dan tambahkan field jika belum ada
            if (!Schema::hasColumn('appointments', 'reason')) {
                $table->text('reason')->nullable()->after('status');
            }
            if (!Schema::hasColumn('appointments', 'service_type')) {
                $table->string('service_type')->nullable()->after('reason');
            }
            if (!Schema::hasColumn('appointments', 'complaints')) {
                $table->text('complaints')->nullable()->after('service_type');
            }
            if (!Schema::hasColumn('appointments', 'notes')) {
                $table->text('notes')->nullable()->after('complaints');
            }
            if (!Schema::hasColumn('appointments', 'rescheduled_at')) {
                $table->timestamp('rescheduled_at')->nullable()->after('scheduled_at');
            }
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $columns = ['reason', 'service_type', 'complaints', 'notes', 'rescheduled_at'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('appointments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};