<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bag_id',
        'from',
        'to',
    ];
    /**
     * Get the post that owns the comment.
     */
    public function bag(): BelongsTo
    {
        return $this->belongsTo(Bag::class);
    }
    /**
     * Get the comments for the blog post.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
    /**
     * Get the comments for the blog post.
     */
    public function trip_logs(): HasMany
    {
        return $this->hasMany(Trip_Log::class);
    }
}
