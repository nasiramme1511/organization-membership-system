<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'type',
        'options',
        'is_required',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function values()
    {
        return $this->hasMany(MemberCustomValue::class);
    }
}
