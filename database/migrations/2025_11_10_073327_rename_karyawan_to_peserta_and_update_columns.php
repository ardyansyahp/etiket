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
        // Drop foreign key from absen table first
        Schema::table('absen', function (Blueprint $table) {
            $table->dropForeign(['id_karyawan']);
        });

        // Drop foreign key constraints from karyawan table
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropForeign(['id_departemen']);
            $table->dropForeign(['id_plant']);
        });

        // Drop columns that are not needed
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_lahir',
                'tempat_lahir',
                'jabatan',
                'umur',
                'alamat',
                'tanggal_masuk_kerja',
                'status_karyawan',
                'id_departemen',
                'id_plant'
            ]);
        });

        // Rename column nik to no_peserta using DB::statement
        DB::statement('ALTER TABLE `karyawan` CHANGE `nik` `no_peserta` VARCHAR(255) NOT NULL');

        // Rename column no_telp to no_hp using DB::statement
        DB::statement('ALTER TABLE `karyawan` CHANGE `no_telp` `no_hp` VARCHAR(255) NULL');

        // Add new columns
        Schema::table('karyawan', function (Blueprint $table) {
            $table->boolean('status_kirim_email')->default(false)->after('email');
            $table->boolean('status_kirim_whatsapp')->default(false)->after('no_hp');
        });

        // Rename table from karyawan to peserta
        Schema::rename('karyawan', 'peserta');

        // Re-add foreign key to absen table with new table name
        Schema::table('absen', function (Blueprint $table) {
            $table->foreign('id_karyawan')->references('id')->on('peserta')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key from absen table
        Schema::table('absen', function (Blueprint $table) {
            $table->dropForeign(['id_karyawan']);
        });

        // Rename table back from peserta to karyawan
        Schema::rename('peserta', 'karyawan');

        // Re-add foreign key to absen table with old table name
        Schema::table('absen', function (Blueprint $table) {
            $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
        });

        // Remove new columns
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn(['status_kirim_email', 'status_kirim_whatsapp']);
        });

        // Rename column no_hp back to no_telp using DB::statement
        DB::statement('ALTER TABLE `karyawan` CHANGE `no_hp` `no_telp` VARCHAR(255) NULL');

        // Rename column no_peserta back to nik using DB::statement
        DB::statement('ALTER TABLE `karyawan` CHANGE `no_peserta` `nik` VARCHAR(255) NOT NULL');

        // Add back dropped columns
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dateTime('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('jabatan')->nullable();
            $table->integer('umur')->nullable();
            $table->text('alamat')->nullable();
            $table->dateTime('tanggal_masuk_kerja')->nullable();
            $table->string('status_karyawan')->nullable();
            $table->foreignId('id_departemen')->nullable()->constrained('departemen')->onDelete('set null');
            $table->foreignId('id_plant')->nullable()->constrained('plant')->onDelete('set null');
        });
    }
};
