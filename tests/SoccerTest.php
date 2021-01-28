<?php

namespace AxlMedia\SportradarSdk\Test;

use AxlMedia\SportradarSdk\Facade as Sportradar;

class SoccerTest extends TestCase
{
    public function test_soccer_sport_events_summary()
    {
        [
            $production,
            $trial,
        ] = Sportradar::sport('soccer')->sportEvents()->debug()->getSummary('sr:sport_event:123');

        $this->assertEquals($production, 'https://api.sportradar.com/soccer-extended/production/v4/en/sport_events/sr:sport_event:123/summary.json?api_key=some-key&offset=0&limit=500');
        $this->assertEquals($trial, 'https://api.sportradar.com/soccer-extended/trial/v4/en/sport_events/sr:sport_event:123/summary.json?api_key=some-trial-key&offset=0&limit=500');
    }
}
