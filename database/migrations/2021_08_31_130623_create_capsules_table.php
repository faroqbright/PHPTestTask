<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapsulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capsules', function (Blueprint $table) {
            $table->id();
            $table->string('capsule_serial')->nullable();
            $table->string('capsule_id')->nullable();
            $table->string('status')->nullable();
            $table->string('original_launch')->nullable();
            $table->string('original_launch_unix')->nullable();
            $table->integer('landings')->nullable();
            $table->string('type')->nullable();
            $table->string('details')->nullable();
            $table->integer('reuse_count')->nullable();
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
        Schema::dropIfExists('capsules');
    }
}
