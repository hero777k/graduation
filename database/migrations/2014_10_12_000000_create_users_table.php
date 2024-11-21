<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->comment("名前");
            $table->string('email',255)->unique()->comment("メールアドレス");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255)->comment("パスワード");
            $table->rememberToken();
            $table->integer("role")->length(2)->default(2)->comment("1:管理者、2=一般");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
