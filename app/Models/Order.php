<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['subscription_id', 'week_start_date', 'delivery_date', 'status', 'delivery_notes'])]
class Order extends Model
{
    protected function casts(): array
    {
        return [
            'week_start_date' => 'date',
            'delivery_date' => 'date',
        ];
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
