<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign key constraint
        Schema::table('absen', function (Blueprint $table) {
            $table->dropForeign(['id_karyawan']);
        });

        // Rename column id_karyawan to id_peserta using DB::statement
        DB::statement('ALTER TABLE `absen` CHANGE `id_karyawan` `id_peserta` BIGINT UNSIGNED NOT NULL');

        // Re-add foreign key constraint with new column name
        Schema::table('absen', function (Blueprint $table) {
            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraint
        Schema::table('absen', function (Blueprint $table) {
            $table->dropForeign(['id_peserta']);
        });

        // Rename column id_peserta back to id_karyawan using DB::statement
        DB::statement('ALTER TABLE `absen` CHANGE `id_peserta` `id_karyawan` BIGINT UNSIGNED NOT NULL');

        // Re-add foreign key constraint with old column name
        Schema::table('absen', function (Blueprint $table) {
            $table->foreign('id_karyawan')->references('id')->on('peserta')->onDelete('cascade');
        });
    }
};
