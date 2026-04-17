<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCustomValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'custom_field_id',
        'value',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function customField()
    {
        return $this->belongsTo(CustomField::class);
    }
}
