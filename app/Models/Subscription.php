<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'plan_id', 'start_date', 'duration_weeks', 'total_price', 'status', 'delivery_address', 'notes'])]
class Subscription extends Model
{
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'total_price' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function selections()
    {
        return $this->hasMany(MealSelection::class);
    }
}
