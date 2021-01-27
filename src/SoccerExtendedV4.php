<?php

namespace AxlMedia\SportradarSdk;

class SoccerExtendedV4 extends Client
{
    /**
     * Initialize the class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->placeholder(
            '/soccer-extended/{access_level}/v4/{language_code}{endpoint}.{format}'
        );
    }

    /**
     * Create a new Competition instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\ExtendedV4\Competition
     */
    public function competitions()
    {
        return new Soccer\ExtendedV4\Competition;
    }

    /**
     * Create a new Competitor instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\ExtendedV4\Competitor
     */
    public function competitors()
    {
        return new Soccer\ExtendedV4\Competitor;
    }

    /**
     * Create a new Player instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\ExtendedV4\Player
     */
    public static function players()
    {
        return new Soccer\ExtendedV4\Player;
    }

    /**
     * Create a new Season instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\ExtendedV4\Season
     */
    public function seasons()
    {
        return new Soccer\ExtendedV4\Season;
    }

    /**
     * Create a new SportEvent instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\ExtendedV4\SportEvent
     */
    public static function sportEvents()
    {
        return new Soccer\ExtendedV4\SportEvent;
    }
}
