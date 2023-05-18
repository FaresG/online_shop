<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->ulid = Str::ulid();
        });
    }

    protected $guarded = ['id'];

    public function paymentDetails(): HasOne
    {
        return $this->hasOne(PaymentDetails::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItems::class);
    }

    public function scopeOfLoggedInUser(Builder $query): void
    {
        $query->where('user_id', auth()->user()->id);
    }
}
