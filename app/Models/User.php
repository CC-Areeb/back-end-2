<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'super_admin',
        'admin',
        'user',
        'account_status',
    ];

    public function getUserDisplayFields(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'super_admin' => $this->super_admin,
            'admin' => $this->admin,
            'user' => $this->user,
            'account_status' => $this->account_status,
            'created_at' => Carbon::parse($this->created_at)->toDayDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDayDateTimeString(),
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isSuperAdmin()
    {
        return $this->super_admin == 1;
    }

    public function createdTasks(): HasMany
    {
        return $this->hasMany(ToDo::class, 'task_creator');
    }

    public function assignedTasks(): HasMany
    {
        return $this->hasMany(ToDo::class, 'user_id');
    }
}
