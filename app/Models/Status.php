<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Status extends Model
{
  protected $fillable = [
    'title',
    'user_id'
  ];

  public $timestamps = false;

  public function tasks()
  {
    return $this->hasMany(Task::class)->where('user_id', Auth::id())->orderBy('order');
  }
}
