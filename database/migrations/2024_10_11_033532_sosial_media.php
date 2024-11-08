<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('sosial_media', function (Blueprint $table) {
        $table->id();
        $table->string('instagram');
        $table->string('youtube');
        $table->string('x');
        $table->string('logo');
        $table->string('nama_perusahaan');
        $table->string('alamat');
        $table->string('telephone');
        $table->string('email');
        $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
