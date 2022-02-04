<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable = [
    'title',
    'date_delivery',
    'order',
    'user_id',
    'status_id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function status()
  {
    return $this->belongsTo(Status::class);
  }
}
