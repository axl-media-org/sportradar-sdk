<?php

namespace AxlMedia\SportradarSdk\Soccer\V4;

use AxlMedia\SportradarSdk\SoccerV4;

class Competition extends SoccerV4
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
