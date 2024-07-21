<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Cart extends Model
{
    // Attributes
    protected $guarded = ['id'];


    // Relationships
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // Local Scopes

    public function scopeOfCurrentUser(Builder $query, User $user): void
    {
        $query->where('user_id', '=', $user->id)
        ->with(['cartItems', 'cartItems.product']);
    }
}
