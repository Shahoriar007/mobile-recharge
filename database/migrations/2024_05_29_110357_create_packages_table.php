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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->decimal('regi_charge', 8, 2)->nullable();
            $table->decimal('regi_bonus', 8, 2)->nullable();
            $table->decimal('regi_cashback', 8, 2)->nullable();
            $table->decimal('trans_charge', 8, 2)->nullable();
            $table->decimal('trans_bonus', 8, 2)->nullable();
            $table->decimal('charge_free_trans', 8, 2)->nullable();
            $table->decimal('daily_charge', 8, 2)->nullable();
            $table->decimal('daily_bonus', 8, 2)->nullable();
            $table->decimal('refer_plan', 8, 2)->nullable();
            $table->decimal('stock_limit', 8, 2)->nullable();
            $table->decimal('withdraw_limit', 8, 2)->nullable();
            $table->decimal('offline_requ', 8, 2)->nullable();
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
        Schema::dropIfExists('packages');
    }
};
