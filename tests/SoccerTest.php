<?php

namespace AxlMedia\SportradarSdk\Test;

use AxlMedia\SportradarSdk\Sportradar;

class SoccerTest extends TestCase
{
    public function test_soccer_matches_summary()
    {
        [
            $production,
            $trial,
        ] = Sportradar::sport('soccer')->match()->debug()->getSummary('sr:sport_event:123');

        $this->assertEquals($production, 'https://api.sportradar.com/soccer-extended/production/v4/en/sport_events/sr:sport_event:123/summary.json?api_key=some-key');
        $this->assertEquals($trial, 'https://api.sportradar.com/soccer-extended/trial/v4/en/sport_events/sr:sport_event:123/summary.json?api_key=some-trial-key');
    }
}
