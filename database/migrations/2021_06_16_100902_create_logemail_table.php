<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogemailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logemail', function (Blueprint $table) {
            $table->id();
            $table->char('email', 100)->index();
            $table->char('name', 255);
            $table->text('subject');
            $table->text('body');
            $table->char('transport', 50)->index();
            $table->integer('status')->default(1)->index();
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
        Schema::dropIfExists('logemail');
    }
}
