<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my__parents', function (Blueprint $table) {
            $table->id();
            //Information account For both
            $table->string('Email')->unique();
            $table->string('Password');
            //Father information
            $table->string('Name_Father');
            $table->string('National_ID_Father');
            $table->string('Passport_ID_Father');
            $table->string('Phone_Father');
            $table->string('Job_Father');
            $table->foreignId('Nationality_Father_id')->constrained('nationalities');
            $table->foreignId('Blood_Type_Father_id')->constrained('type__bloods');
            $table->foreignId('Religion_Father_id')->constrained('religions');
            $table->string('Address_Father');
            //Father information
            $table->string('Name_Mother');
            $table->string('National_ID_Mother');
            $table->string('Passport_ID_Mother');
            $table->string('Phone_Mother');
            $table->string('Job_Mother');
            $table->bigInteger('Nationality_Mother_id')->constrained('nationalities');
            $table->bigInteger('Blood_Type_Mother_id')->constrained('type__bloods');
            $table->bigInteger('Religion_Mother_id')->constrained('religions');
            $table->string('Address_Mother');
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
        Schema::dropIfExists('my__parents');
    }
}
