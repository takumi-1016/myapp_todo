<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;

class Home extends Controller
{
    public function top()
    {
        $current_user = Auth::user();
        $tasks =  Auth::user()->tasks()->get();

        return view('home/top', [
            'tasks' => $tasks,
        ]);
    }
}
