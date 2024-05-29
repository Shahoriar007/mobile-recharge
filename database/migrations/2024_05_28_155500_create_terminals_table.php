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
        Schema::create('terminals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('length')->nullable();
            $table->string('category')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('user')->nullable();
            $table->string('password')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
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
        Schema::dropIfExists('terminals');
    }
};
