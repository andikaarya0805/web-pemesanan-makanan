<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['subscription_id', 'menu_item_id', 'week_number', 'delivery_date', 'status'])]
class MealSelection extends Model
{
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
