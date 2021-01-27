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
     * Create a new Match instance.
     *
     * @return \AxlMedia\SportradarSdk\Soccer\Match
     */
    public static function match()
    {
        return new Soccer\ExtendedV4\Match;
    }
}
