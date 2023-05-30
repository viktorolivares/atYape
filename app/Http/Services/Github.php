<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class Github
{
    private const USER = 'viktorolivares';
    private const REPOSITORY = 'atYape';

    public static function  getLanguages()
    {
        $token = config('config.git');

        $url = "https://api.github.com/repos/" . self::USER . "/" . self::REPOSITORY . "/languages";

        $response = Http::withToken($token)->get($url);

        return $response->json();
    }

    public static function getLatestChanges()
    {
        $token = config('config.git');

        // Obtener los últimos commits
        $commitsUrl = "https://api.github.com/repos/" . self::USER . "/" . self::REPOSITORY . "/commits";
        $commitsResponse = Http::withToken($token)->get($commitsUrl);
        $commits = $commitsResponse->json();

        // Obtener los últimos cambios en el repositorio
        $lastChangeUrl = "https://api.github.com/repos/" . self::USER . "/" . self::REPOSITORY . "/events";
        $lastChangeResponse = Http::withToken($token)->get($lastChangeUrl);
        $lastChange = $lastChangeResponse->json();

        return [
            'commits' => $commits,
            'lastChange' => $lastChange,
        ];
    }
}
