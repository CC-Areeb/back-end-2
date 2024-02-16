<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'to_dos_id',
        'status',
    ];

    public function toDo(): BelongsTo
    {
        return $this->belongsTo(ToDo::class);
    }
}
