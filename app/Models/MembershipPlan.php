<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'price',
        'duration_days',
        'description',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
