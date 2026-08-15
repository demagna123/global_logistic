<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            
            // Infos client
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone')->nullable();
            
            // Détails du devis
            $table->enum('service_type', [
                'transit_douane',
                'tierce_detention',
                'representation_commerciale',
                'transport_logistique',
                'entreposage'
            ]);
            $table->text('description');
            $table->decimal('amount', 12, 2)->nullable(); // Montant du devis
            
            // Validité
            $table->date('valid_until')->nullable();
            
            // Statut
            $table->enum('status', ['draft', 'sent', 'accepted', 'rejected'])->default('draft');
            
            // Notes admin
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};