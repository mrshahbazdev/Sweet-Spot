<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
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

    public function score()
    {
        return $this->hasOne(CustomerScore::class);
    }
}
