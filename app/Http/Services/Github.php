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

    public static function getLatestChanges()
    {
        $token = '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';
        $user = 'viktorolivares';
        $repository = 'atYape';

        // Obtener los últimos commits
        $commitsUrl = "https://api.github.com/repos/{$user}/{$repository}/commits";
        $commitsResponse = Http::withToken($token)->get($commitsUrl);
        $commits = $commitsResponse->json();

        // Obtener los últimos cambios en el repositorio
        $lastChangeUrl = "https://api.github.com/repos/{$user}/{$repository}/events";
        $lastChangeResponse = Http::withToken($token)->get($lastChangeUrl);
        $lastChange = $lastChangeResponse->json();

        return [
            'commits' => $commits,
            'lastChange' => $lastChange,
        ];
    }
}
