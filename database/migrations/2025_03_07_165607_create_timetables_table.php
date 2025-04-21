<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('class_id');
         $table->unsignedBigInteger('subject_id');
         $table->string('day'); // Monday, Tuesday, etc.
         $table->time('start_time');
         $table->time('end_time');
         $table->unsignedBigInteger('teacher_id')->nullable();
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
        Schema::dropIfExists('timetables');
    }
}
