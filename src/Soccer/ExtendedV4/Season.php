<?php

namespace AxlMedia\SportradarSdk\Soccer\ExtendedV4;

use AxlMedia\SportradarSdk\SoccerExtendedV4;

class Season extends SoccerExtendedV4
{
    public function all()
    {
        return $this->call('GET', '/seasons');
    }

    public function getCompetitors(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/competitors");
    }

    public function getCompetitorStatistics(string $id, string $competitorId)
    {
        return $this->call('GET', "/seasons/{$id}/competitors/{$competitorId}/statistics");
    }

    public function getInfo(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/info");
    }

    public function getLeaders(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/leaders");
    }

    public function getLineups(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/lineups");
    }

    public function getMissingPlayers(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/missing_players");
    }

    public function getPlayers(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/players");
    }

    public function getProbabilities(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/probabilities");
    }

    public function getOutrightProbabilities(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/outright_probabilities");
    }

    public function getSchedules(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/schedules");
    }

    public function getStandings(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/standings");
    }

    public function getSummaries(string $id)
    {
        return $this->call('GET', "/seasons/{$id}/summaries");
    }
}
