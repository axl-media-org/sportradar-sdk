<?php

namespace AxlMedia\SportradarSdk\Soccer\ExtendedV4;

use AxlMedia\SportradarSdk\SoccerExtendedV4;

class SportEvent extends SoccerExtendedV4
{
    /**
     * Get match summary.
     *
     * @param  string  $id
     * @return string
     */
    public function getSummary(string $id)
    {
        return $this->call('GET', "/sport_events/{$id}/summary");
    }
}
