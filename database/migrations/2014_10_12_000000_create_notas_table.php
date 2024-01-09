<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('type');
            $table->string('nomor');
            $table->string('marketing');
            $table->date('tanggal');
            $table->string('bulan');
            $table->string('tahun');
            $table->string('customer');
            $table->string('telepon');
            $table->string('amount');
            $table->string('payment');
            $table->string('paid');
            $table->string('total');
            $table->string('street');
            $table->string('district');
            $table->string('city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
