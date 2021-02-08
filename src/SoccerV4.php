<?php

namespace AxlMedia\SportradarSdk;

class SoccerV4 extends Client
{
    /**
     * Initialize the class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->placeholder(
            '/soccer/{access_level}/v4/{language_code}{endpoint}.{format}'
        );
    }

    /**
     * Create a new Competition instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\V4\Competition
     */
    public function competitions()
    {
        return new Soccer\V4\Competition;
    }

    /**
     * Create a new Competitor instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\V4\Competitor
     */
    public function competitors()
    {
        return new Soccer\V4\Competitor;
    }

    /**
     * Create a new Player instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\V4\Player
     */
    public static function players()
    {
        return new Soccer\V4\Player;
    }

    /**
     * Create a new Season instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\V4\Season
     */
    public function seasons()
    {
        return new Soccer\V4\Season;
    }

    /**
     * Create a new SportEvent instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\V4\SportEvent
     */
    public static function sportEvents()
    {
        return new Soccer\V4\SportEvent;
    }
}
