<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Tambahkan field-field baru
            $table->string('service_type')->nullable()->after('status');
            $table->text('complaints')->nullable()->after('service_type');
            $table->text('notes')->nullable()->after('complaints');
            $table->text('reason')->nullable()->after('notes');
            $table->timestamp('rescheduled_at')->nullable()->after('scheduled_at');
            
            // Ubah status menjadi enum untuk konsistensi
            $table->enum('status', [
                'pending', 'approved', 'cancelled', 'rescheduled', 'completed'
            ])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'service_type', 
                'complaints', 
                'notes', 
                'reason', 
                'rescheduled_at'
            ]);
            // Kembalikan status ke string jika perlu
            $table->string('status')->change();
        });
    }
};