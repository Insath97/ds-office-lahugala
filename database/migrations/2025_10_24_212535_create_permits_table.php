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
        Schema::create('permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('gn_division_id')->constrained('g_n_divisions')->onDelete('cascade');
            $table->string('code')->unique();
            $table->boolean('permit_holder_copy')->default(false);
            $table->boolean('office_holder_copy')->default(false);
            $table->boolean('ledger')->default(false);
            $table->text('address');

            $table->enum('type_of_land', [
                'agricultural',
                'residential',
                'commercial',
                'industrial',
                'forest',
                'barren',
                'pasture',
                'mining',
                'recreational',
                'conservation'
            ]);

            $table->enum('extend', [
                'acre',
                'root',
                'perches',
                'hectare'
            ]);

            $table->boolean('surveyed')->default(false);
            $table->string('surveyed_plan_no')->nullable();

            // Boundaries
            $table->string('boundary_north');
            $table->string('boundary_east');
            $table->string('boundary_south');
            $table->string('boundary_west');

            // Nomination information
            $table->boolean('nomination')->default(false);
            $table->string('name_of_nominees')->nullable();
            $table->string('relationship')->nullable();
            $table->date('nominated_date')->nullable();

            // Grant information
            $table->boolean('grant_issued')->default(false);
            $table->string('grant_no')->nullable();
            $table->string('land_registry_no')->nullable();
            $table->date('date_of_issued')->nullable();

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permits');
    }
};
