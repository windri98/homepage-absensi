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
        Schema::table('attendances', function (Blueprint $table) {
            $table->timestamp('clock_in_time')->nullable()->after('clock_in');
            $table->timestamp('clock_out_time')->nullable()->after('clock_out');
            $table->enum('work_type', ['office', 'remote', 'field'])->default('office')->after('status');
            $table->string('photo_clock_in')->nullable()->after('notes');
            $table->string('photo_clock_out')->nullable()->after('photo_clock_in');
            $table->decimal('latitude_clock_in', 10, 8)->nullable()->after('photo_clock_out');
            $table->decimal('longitude_clock_in', 11, 8)->nullable()->after('latitude_clock_in');
            $table->decimal('latitude_clock_out', 10, 8)->nullable()->after('longitude_clock_in');
            $table->decimal('longitude_clock_out', 11, 8)->nullable()->after('latitude_clock_out');
            $table->text('work_summary')->nullable()->after('longitude_clock_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'clock_in_time',
                'clock_out_time', 
                'work_type',
                'photo_clock_in',
                'photo_clock_out',
                'latitude_clock_in',
                'longitude_clock_in',
                'latitude_clock_out',
                'longitude_clock_out',
                'work_summary'
            ]);
        });
    }
};
