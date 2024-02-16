<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ToDo extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'task_name',
        'task_description',
        'task_creator',
        'user_id',
        'start_date',
        'end_date',
        'start',
        'finish',
    ];

    public $timestamps = false;

    public function getTaskDisplayFields(): array
    {
        return [
            'task_name' => $this->task_name,
            'task_description' => $this->task_description,
            'task_creator' => User::where('id', $this->task_creator)->first(),
            'assigned_user' => User::where('id', $this->user_id)->first(),
            'start_date' => Carbon::parse($this->start_date)->toDayDateTimeString(),
            'end_date' => Carbon::parse($this->end_date)->toDayDateTimeString(),
            'start' => $this->start,
            'finish' => $this->finish,
        ];
    }

    public function task_creator()
    {
        return $this->belongsTo(User::class);
    }

    public function user_id()
    {
        return $this->belongsTo(User::class);
    }

    public function taskStatus(): HasMany
    {
        return $this->hasMany(TaskStatus::class);
    }
}
