<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_responses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('before_balance')->nullable();
            $table->string('after_balance')->nullable();
            $table->string('before_amount')->nullable();
            $table->string('after_amount')->nullable();
            $table->string('before_trans_code')->nullable();
            $table->string('after_trans_code')->nullable();
            $table->string('must_include')->nullable();
            $table->string('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_responses');
    }
};
