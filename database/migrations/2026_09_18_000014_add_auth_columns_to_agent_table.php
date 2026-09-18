<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agent', function (Blueprint $table) {
            $table->string('email')->nullable()->unique()->after('nom_agent');
            $table->string('password')->nullable()->after('email');
            $table->string('role', 30)->default('agent')->after('password');
            $table->rememberToken()->after('role');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('agent', function (Blueprint $table) {
            $table->dropColumn(['email', 'password', 'role', 'remember_token', 'last_login_at']);
        });
    }
};
