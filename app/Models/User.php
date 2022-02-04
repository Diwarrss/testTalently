<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

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
  ];

  public function tasks()
  {
    return $this->hasMany(Task::class);
  }

  protected static function booted()
  {
    static::created(function ($user) {
      // Create default tasks
      $user->tasks()->createMany([
        [
          'title' => 'Agregar subtareas al kanban',
          'date_delivery' => now(),
          'order' => 0,
          'status_id' => 1
        ],
        [
          'title' => 'Testing Kanban',
          'date_delivery' => now(),
          'order' => 0,
          'status_id' => 2
        ]
      ]);
    });
  }
}
