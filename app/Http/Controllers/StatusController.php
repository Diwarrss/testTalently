<?php

namespace App\Http\Controllers;

use App\Models\Status;

class StatusController extends Controller
{
  public function index()
  {
    $status = Status::with('tasks')->get();

    return response()->json($status);
  }
}
