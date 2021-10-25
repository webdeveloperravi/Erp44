<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('meta_title');
            $table->string('meta_desc');
            $table->string('featured_img_url');
            $table->string('featured_img_alt');
            $table->longText('content');
            $table->string('url_slug');
            $table->string('permalink');
            $table->foreignId('category_id');
            $table->foreignId('author_id');
            $table->boolean('visibility');
            $table->foreignId('parent_page_id');
            $table->boolean('status');
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
