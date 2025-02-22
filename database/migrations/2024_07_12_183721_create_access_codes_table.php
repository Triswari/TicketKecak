<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('access_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('email');
            $table->boolean('is_used')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('access_codes');
    }
};
