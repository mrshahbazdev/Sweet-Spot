<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerScore extends Model
{
    protected $fillable = [
        'customer_id',
        'margin_per_hour',
        'profitability_score',
        'effort_score',
        'chemistry_score',
        'growth_score',
        'repeat_score',
        'recommendation_score',
        'payment_score',
        'total_score',
        'rank',
        'top_flag',
        'calculated_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
