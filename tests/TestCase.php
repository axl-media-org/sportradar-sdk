<?php

namespace AxlMedia\SportradarSdk\Test;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * The history for Guzzle mocks.
     *
     * @var array
     */
    protected $history = [];

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->history = [];
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            \AxlMedia\SportradarSdk\SportradarSdkServiceProvider::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'wslxrEFGWY6GfGhvN9L3wH3KSRJQQpBD');
    }

    /**
     * Generate a handler stack for testing external APIs.
     *
     * @param  array $responses
     * @return HandlerStack
     */
    protected function generateMockHandler(array $responses = [])
    {
        $handlerStack = HandlerStack::create(
            new MockHandler($responses)
        );

        $handlerStack->push(Middleware::history($this->history));

        return $handlerStack;
    }
}
