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
            // blog features
            $table->id();
            $table->string("title");
            $table->string("slug")->unique();
            $table->string("featured_image")->nullable();
            $table->unsignedBigInteger('blog_category_id')->nullable();
            $table->string("author")->nullable();
            $table->longText("content")->nullable();

            // seo features
            $table->enum('index_status', [1, 2])->default(2)->comment('1=index, 2=noindex');
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
            $table->softDeletes();
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
