<?php

namespace AxlMedia\SportradarSdk;

class PaginatedResult
{
    /**
     * The paginator.
     *
     * @var \AxlMedia\SportradarSdk\Paginator
     */
    protected $paginator;

    /**
     * The method used for the result.
     *
     * @var string
     */
    protected $method;

    /**
     * The endpoint call used for the result.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The client instance.
     *
     * @var \AxlMedia\SportradarSdk\Client
     */
    protected $client;

    /**
     * Initialize the class.
     *
     * @param  \AxlMedia\SportradarSdk\Paginator  $paginator
     * @param  string  $method
     * @param  string  $endpoint
     * @param  \AxlMedia\SportradarSdk\Client  $client
     * @return void
     */
    public function __construct(Paginator $paginator, string $method, string $endpoint, Client $client)
    {
        $this->paginator = $paginator;
        $this->method = $method;
        $this->endpoint = $endpoint;
        $this->client = $client;
    }

    /**
     * Get the next page.
     *
     * @return \Rennokki\PulseAPI\PaginatedResult
     */
    public function next()
    {
        return $this->client
            ->next($this->paginator->perPage())
            ->call($this->method, $this->endpoint);
    }

    /**
     * Get the content of the result.
     *
     * @return array
     */
    public function getContent(): array
    {
        return $this->paginator->toArray()['data'];
    }

    /**
     * Make dynamic calls into the collection.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func([$this->paginator, $method], $parameters);
    }
}
