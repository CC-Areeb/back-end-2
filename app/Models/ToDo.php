<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;

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
}
