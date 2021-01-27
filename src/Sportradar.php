<?php

namespace AxlMedia\SportradarSdk;

class Sportradar
{
    /**
     * Initialize a new client from config.
     *
     * @param  string  $name
     * @return \AxlMedia\SportradarSdk\Client
     */
    public static function sport(string $name)
    {
        $client = config("sportradar.sports.{$name}.client");

        return new $client;
    }
}
