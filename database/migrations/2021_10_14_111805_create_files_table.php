<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('files', function (Blueprint $table) {
            $table->string('uuid');
            $table->timestamps();
            $table->text('additional_path')->nullable();
            $table->string('extension');
            $table->boolean('webp')->default(false);
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('size')->nullable();
            $table->integer('sort')->nullable();
            $table->bigInteger('gallery_id')->unsigned()->nullable();

            $table->index('uuid');
            $table->foreign('gallery_id')->references('id')->on('galleries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('files');
    }
}
