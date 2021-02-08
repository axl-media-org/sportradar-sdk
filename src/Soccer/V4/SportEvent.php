<?php

namespace AxlMedia\SportradarSdk\Soccer\V4;

use AxlMedia\SportradarSdk\SoccerV4;
use Carbon\Carbon;
use DateTime;

class SportEvent extends SoccerV4
{
    public function getFunFacts(string $id)
    {
        return $this->call('GET', "/sport_events/{$id}/summary");
    }

    public function getLeagueTimeline(string $id)
    {
        return $this->call('GET', "/sport_events/{$id}/league_timeline");
    }

    public function getLineups(string $id)
    {
        return $this->call('GET', "/sport_events/{$id}/lineups");
    }

    public function getLiveSummaries()
    {
        return $this->call('GET', '/schedules/live/summaries');
    }

    public function getLiveTimelines()
    {
        return $this->call('GET', '/schedules/live/timelines');
    }

    public function getLiveTimelinesDelta()
    {
        return $this->call('GET', '/schedules/live/timelines_delta');
    }

    public function getSummary(string $id)
    {
        return $this->call('GET', "/sport_events/{$id}/summary");
    }

    public function getTimeline(string $id)
    {
        return $this->call('GET', "/sport_events/{$id}/timeline");
    }

    public function getRemoved()
    {
        return $this->call('GET', '/sport_events/removed');
    }

    public function getSummariesForDate($date)
    {
        if ($date instanceof DateTime) {
            $date = Carbon::parse($date)->toDateString();
        }

        return $this->call('GET', "/schedules/{$date}/summaries");
    }
}
