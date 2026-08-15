<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $fillable = [
        'quote_id',
        'description',
        'quantity',
        'unit_price',
        'total'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    // Relation inverse
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    // Calcul automatique du total
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
            if ($item->quantity && $item->unit_price) {
                $item->total = $item->quantity * $item->unit_price;
            }
        });
    }
}