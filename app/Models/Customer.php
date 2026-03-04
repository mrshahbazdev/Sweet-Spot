<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'industry',
        'company_size',
        'revenue',
        'profit_margin_eur',
        'margin_percent',
        'effort_hours',
        'chemistry_score',
        'growth_score',
        'repeat_rate',
        'recommendations',
        'payment_willingness',
        'notes'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Automatically filter queries to only show the authenticated user's customers
        static::addGlobalScope('user_id', function ($builder) {
            if (auth()->check()) {
                $builder->where('user_id', auth()->id());
            }
        });

        // Automatically set the user_id when creating a new customer
        static::creating(function ($customer) {
            if (auth()->check()) {
                $customer->user_id = auth()->id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function score()
    {
        return $this->hasOne(CustomerScore::class);
    }
}
