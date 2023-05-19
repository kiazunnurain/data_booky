<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'author', 'synopsis_content', 'writer', 'image'];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'writer', 'id');
    }

    public function reviews(): HasMany
    {
       return $this->hasMany(Review::class, 'book_id', 'id');
    }
}
