<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'description', 'price_per_week', 'meals_per_week', 'features', 'is_active'])]
class Plan extends Model
{
    protected function casts(): array
    {
        return [
            'features' => 'array',
            'price_per_week' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function weeklyMenus()
    {
        return $this->hasMany(WeeklyMenu::class);
    }
}
