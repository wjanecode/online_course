<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('cover')->nullable();
            $table->string('description')->nullable();
            $table->integer('lessons_count')->default(0);
            $table->decimal('price',7,2)->default(0);
            $table->integer('duration')->default(0);
            $table->integer('teacher_id')->default(1);
            $table->integer('students_count')->default(0);
            $table->string('is_hidden',2)->default('F');
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
        Schema::dropIfExists('courses');
    }
}
