<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class Github
{
    public static function  getLanguages()
    {
        $token = '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';
        $user = 'viktorolivares';
        $repository = 'atYape';

        $url = "https://api.github.com/repos/{$user}/{$repository}/languages";

        $response = Http::withToken($token)->get($url);

        return $response->json();
    }
}
