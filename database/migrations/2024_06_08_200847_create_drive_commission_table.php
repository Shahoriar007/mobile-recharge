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
        Schema::create('drive_commission', function (Blueprint $table) {
            $table->id();
            $table->string('range')->nullable();
            $table->string('drive_code')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->decimal('commission')->nullable();
            $table->decimal('charge')->nullable();
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
        Schema::dropIfExists('drive_commission');
    }
};
