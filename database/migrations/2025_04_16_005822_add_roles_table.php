<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 50);
        });

        // Insert default roles
        FacadesDB::table('roles')->insert([
            ['nom' => 'admin'],
            ['nom' => 'client'],
            ['nom' => 'livreur'],
            ['nom' => 'pharmacien'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};