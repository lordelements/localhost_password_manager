<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'theme',
        'auto_logout_minutes',
        'generator_defaults',
        'backup_preferences',
    ];

    protected function casts(): array
    {
        return [
            'generator_defaults' => 'array',
            'backup_preferences' => 'array',
            'auto_logout_minutes' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}