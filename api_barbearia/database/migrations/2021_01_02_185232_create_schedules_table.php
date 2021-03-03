<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{

    public function up():void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->dateTime('schedule_date');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('service_id');

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
}
