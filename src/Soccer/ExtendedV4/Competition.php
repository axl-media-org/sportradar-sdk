<?php

namespace AxlMedia\SportradarSdk\Soccer\ExtendedV4;

use AxlMedia\SportradarSdk\SoccerExtendedV4;

class Competition extends SoccerExtendedV4
{
    public function all()
    {
        return $this->call('GET', '/competitions');
    }

    public function getInfo(string $id)
    {
        return $this->call('GET', "/competitions/{$id}/info");
    }

    public function getSeasons(string $id)
    {
        return $this->call('GET', "/competitions/{$id}/seasons");
    }
}
