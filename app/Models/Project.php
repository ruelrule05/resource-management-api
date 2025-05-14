<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    protected function casts()
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
