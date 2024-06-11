<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class LeaderboardController extends Controller
{
    public function index(): JsonResponse
    {
        $topUsers = User::orderBy('points', 'desc')->take(5)->get(['name', 'points']);
        return response()->json($topUsers);
    }
}
