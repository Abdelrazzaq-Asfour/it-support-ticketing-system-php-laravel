<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل التهجير لإضافة العمود
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // إضافة حقل solver_id وهو عبارة عن Foreign Key يربط بجدول users
            // نستخدم nullable لأن التذكرة في البداية لا يكون لها "حلّال"
            $table->foreignId('solver_id')
                  ->after('user_id') 
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null'); // إذا حذفت الأدمن، تبقى التذكرة ولا تُحذف
        });
    }

    /**
     * التراجع عن التهجير وحذف العمود
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // حذف الربط أولاً ثم حذف العمود
            $table->dropForeign(['solver_id']);
            $table->dropColumn('solver_id');
        });
    }
};