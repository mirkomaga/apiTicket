<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ticket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{

            Schema::create('ticket', function (Blueprint $table) {
                // $table->increments('id');
                // $table->string('name');
                // $table->string('email')->unique();
                // $table->timestamp('email_verified_at')->nullable();
                // $table->string('password');
    
                $table->increments('id');
                $table->string('titolo');
                $table->string('descrizione');
                $table->string('applicativo');
                $table->string('segnalatoDa');
                $table->string('segnalatoData');
                $table->string('inseritoDa');
                $table->string('inseritoData');
                $table->string('priorita');
                $table->string('status');
                $table->rememberToken();
                $table->timestamps();

                // $table->foreign('id')->references('idTicket')->on('assegnaTicket')->onDelete('cascade');
            });
        }catch(Exception $e){
            print $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('ticket');
    }
}
