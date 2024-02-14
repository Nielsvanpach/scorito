<?php

namespace App;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ScoritoClassicsGame {
    private HttpClientInterface $client;
    private int $raceId;
    private ProCyclingStatsFetcher $fetcher;

    public function __construct(int $raceId, array $filterRaces)
    {
        $this->raceId = $raceId;
        $this->client = HttpClient::create();
        $this->fetcher = new ProCyclingStatsFetcher($this->client, $filterRaces);
    }

    public function fetchTeams(): array
    {
        $response = $this->client->request('GET', 'https://cycling.scorito.com/cycling/v2.0/team');
        $scoritoData = $response->toArray();

        return $scoritoData['Content'];
    }

    public function fetch(): array
    {
        $response = $this->client->request('GET', 'https://cycling.scorito.com/cyclingteammanager/v2.0/marketrider/' . $this->raceId);
        $scoritoData = $response->toArray();

        $teams = $this->fetchTeams();

        $filtered = $scoritoData['Content'];

        $filtered = ScoritoFormatter::formatQualities($filtered);
        $filtered = ScoritoFormatter::formatType($filtered);

        $filtered = array_map(fn (array $rider) => ScoritoFormatter::formatTeam($rider, $teams), $filtered);
        $filtered = ScoritoFormatter::filterColumns($filtered);

        return $this->fetcher->fetchRiders($filtered, true, true, true);
    }
}
