<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'published_date',
        'is_published'
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_published' => 'boolean'
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($news) {
            $news->slug = Str::slug($news->title);
        });
    }

    // Relation with images
    public function images()
    {
        return $this->hasMany(NewsImage::class)->orderBy('order');
    }

    // Get main image (first one)
    public function getMainImageAttribute()
    {
        return $this->images()->first();
    }

    // Check if can add more images (max 3)
    public function canAddImage()
    {
        return $this->images()->count() < 3;
    }

    // Scope for published news
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_date', '<=', now());
    }

    // Scope for recent news
    public function scopeRecent($query, $limit = 5)
    {
        return $query->published()->orderBy('published_date', 'desc')->limit($limit);
    }
}
