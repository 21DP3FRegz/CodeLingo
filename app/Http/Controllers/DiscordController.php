<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiscordController extends Controller
{
    public function login() {
        $discord_url = env('DISCORD_URL');
        return redirect($discord_url);
    }

    public function processOauth() {
        return 'hey';
    }
}
