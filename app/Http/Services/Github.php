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
