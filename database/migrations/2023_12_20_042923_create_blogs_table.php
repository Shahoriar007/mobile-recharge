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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("feature_picture")->nullable();
            $table->string("slug")->nullable();
            $table->string("slug_url")->nullable();
            $table->string("read_time")->nullable();
            $table->text("description")->nullable();
            $table->unsignedBigInteger('blog_category_id')->nullable()->comment('from blog_categories table');
            $table->unsignedBigInteger('author_id')->nullable()->comment('from users table');

            $table->enum('index_status', ['index', 'not_index'])->default('not_index');
            $table->string("canonical_url")->nullable();
            $table->string("meta_title")->nullable();
            $table->text("meta_description")->nullable();
            $table->string("meta_url")->nullable();
            $table->dateTime('meta_publish_date')->nullable();

            $table->longText('schema_markup')->nullable();
            $table->longText('custom_code')->nullable();

            $table->unsignedBigInteger('created_by')->nullable()->comment('from users table');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('from users table');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('from users table');
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
        Schema::dropIfExists('blogs');
    }
};
