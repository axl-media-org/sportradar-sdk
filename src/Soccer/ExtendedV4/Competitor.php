<?php

namespace AxlMedia\SportradarSdk\Soccer\ExtendedV4;

use AxlMedia\SportradarSdk\SoccerExtendedV4;

class Competitor extends SoccerExtendedV4
{
    public function getProfile(string $id)
    {
        return $this->call('GET', "/competitors/{$id}/profile");
    }

    public function getSummaries(string $id)
    {
        return $this->call('GET', "/competitors/{$id}/summaries");
    }

    public function getSeasonStatistics(string $seasonId, string $id)
    {
        return $this->call('GET', "/seasons/{$seasonId}/competitors/{$id}/statistics");
    }

    public function getVersus(string $id, string $id2)
    {
        return $this->call('GET', "/competitors/{$id}/versus/{$id2}");
    }
}
