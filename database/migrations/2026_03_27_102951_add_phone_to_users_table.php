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
        Schema::table('users', function (Blueprint $table) {
            // إضافة حقل الهاتف بعد حقل الإيميل مباشرة
            // لم نضع ->nullable() لأنك تريده إجبارياً
            $table->string('phone')->after('email'); 
        });
    }

    /**
     * التراجع عن التهجير وحذف العمود
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};