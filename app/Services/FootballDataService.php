<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class FootballDataService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct(){
        $this->baseUrl = config('services.football_data.base_url');
        $this->apiKey = config('services.football_data.api_key');
    }

    protected function client(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withHeaders([
            'X-Auth-Token' => $this->apiKey,
        ])->baseUrl($this->baseUrl)
            ->withoutVerifying();
    }

    /**
     * @throws ConnectionException
     */
    protected function get(string $endpoint, array $query = []): array
    {
        $response = $this->client()->get($endpoint, $query);

        if ($response->failed()) {
            abort($response->status(), 'Failed to fetch data from Football Data API.' . $response->body());
        }

        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getCompetitions(): array
    {
        return $this->get('/competitions');
    }

    /**
     * @throws ConnectionException
     */
    public function getCompetitionStandings(string $code): array
    {
        return $this->get("/competitions/{$code}/standings");
    }

    /**
     * @throws ConnectionException
     */
    public function getMatches(string $code): array
    {
        return $this->get("/competitions/{$code}/matches");
    }

    /**
     * @throws ConnectionException
     */
    public function getTeam(int $id): array
    {
        return $this->get("/teams/{$id}");
    }
}
