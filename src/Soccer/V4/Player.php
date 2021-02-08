<?php

namespace AxlMedia\SportradarSdk\Soccer\V4;

use AxlMedia\SportradarSdk\SoccerV4;

class Player extends SoccerV4
{
    public function getProfile(string $id)
    {
        return $this->call('GET', "/players/{$id}/profile");
    }

    public function getSummaries(string $id)
    {
        return $this->call('GET', "/players/{$id}/summaries");
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
