<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssegnaTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assegnaTicket', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idUtente_a');
            $table->unsignedInteger('idUtente_da');
            $table->string('assegnato_il');
            $table->string('priorita');
            $table->unsignedInteger('idTicket');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('idTicket')->references('id')->on('ticket')->onDelete('cascade');
            $table->foreign('idUtente_a')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('idUtente_da')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assegnaTicket', function (Blueprint $table) {
            $table->dropColumn('priorita');
        });
    }
}
