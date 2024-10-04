<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemorizedToWordsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('words', 'memorized')) {
            Schema::table('words', function (Blueprint $table) {
                $table->boolean('memorized')->default(false);
            });
        }
    }

    public function down()
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn('memorized');
        });
    }
};