<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'entreprise',
        'service',
        'message',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    // Scope pour les messages non lus
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Marquer comme lu
    public function markAsRead()
    {
        $this->is_read = true;
        $this->read_at = now();
        $this->save();
    }

    // Accesseur pour le nom complet
    public function getFullNameAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}