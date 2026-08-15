<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'service_type',
        'description',
        'amount',
        'valid_until',
        'status',
        'admin_notes'
    ];

    protected $casts = [
        'valid_until' => 'date',
        'amount' => 'decimal:2'
    ];

    // Constantes
    const SERVICE_TYPES = [
        'transit_douane' => 'Transit Douane',
        'tierce_detention' => 'Tierce Détention',
        'representation_commerciale' => 'Représentation Commerciale',
        'transport_logistique' => 'Transport Logistique',
        'entreposage' => 'Entreposage de Marchandises'
    ];

    const STATUSES = [
        'draft' => 'Brouillon',
        'sent' => 'Envoyé au client',
        'accepted' => 'Accepté par le client',
        'rejected' => 'Refusé par le client'
    ];

    // ✅ NOUVEAU : Relation avec les lignes de produit
    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    // ✅ NOUVEAU : Calcul du montant total à partir des lignes
    public function getTotalAmountAttribute()
    {
        return $this->items->sum('total');
    }

    // Accesseurs
    public function getServiceTypeLabelAttribute()
    {
        return self::SERVICE_TYPES[$this->service_type] ?? $this->service_type;
    }

    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    // Scopes
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['draft', 'sent']);
    }
}