<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VaultEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'folder_id',
        'category_id',
        'website_name',
        'website_url',
        'username',
        'email',
        'password_encrypted',
        'notes',
        'favorite',
    ];

    protected function casts(): array
    {
        return [
            'favorite' => 'boolean',
            'password_encrypted' => 'encrypted',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'vault_entry_tag');
    }
}