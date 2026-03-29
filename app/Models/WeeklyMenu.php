<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['week_start_date', 'plan_id', 'menu_items'])]
class WeeklyMenu extends Model
{
    protected function casts(): array
    {
        return [
            'week_start_date' => 'date',
            'menu_items' => 'array',
        ];
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
