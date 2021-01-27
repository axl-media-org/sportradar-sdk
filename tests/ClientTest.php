<?php

namespace AxlMedia\SportradarSdk\Test;

use AxlMedia\SportradarSdk\Facade as Sportradar;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

class ClientTest extends TestCase
{
    public function test_call_with_2xx()
    {
        $response = [
            'summaries' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ],
        ];

        $history = [];

        $handler = new MockHandler([
            new Response(200, [], json_encode($response)),
        ]);

        $handlerStack = HandlerStack::create($handler);

        $handlerStack->push(Middleware::history($history));

        $json = Sportradar::sport('soccer')
            ->sportEvents()
            ->handler($handlerStack)
            ->from('summaries')
            ->call('GET', '/some-endpoint');

        $this->assertSame($response['summaries'], $json);

        /**
         * The response is 2xx right from the start, so only one
         * request will be made to retrieve the data.
         */
        $this->assertCount(1, $history);
    }

    public function test_call_with_non_2xx_then_2xx()
    {
        $response = [
            'summaries' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ],
        ];

        $history = [];

        $handler = new MockHandler([
            new Response(419, ['X-Rate-Limit' => 200]),
            new Response(200, [], json_encode($response)),
        ]);

        $handlerStack = HandlerStack::create($handler);

        $handlerStack->push(Middleware::history($history));

        $json = Sportradar::sport('soccer')
            ->sportEvents()
            ->handler($handlerStack)
            ->call('GET', '/some-endpoint');

        /**
         * Because we have set two keys, the second one works,
         * so it should take it from pool and get the right response.
         */
        $this->assertSame($response, $json);

        /**
         * There were made two calls, one with production and one with trial.
         * The one with production failed, but the trial one worked.
         */
        $this->assertCount(2, $history);
    }

    public function test_call_with_non_2xx()
    {
        $history = [];

        $handler = new MockHandler([
            new Response(419, ['X-Rate-Limit' => 200]),
            new Response(419, ['X-Rate-Limit' => 100]),
        ]);

        $handlerStack = HandlerStack::create($handler);

        $handlerStack->push(Middleware::history($history));

        $json = Sportradar::sport('soccer')
            ->sportEvents()
            ->handler($handlerStack)
            ->call('GET', '/some-endpoint');

        /**
         * Because we have set two keys, both failed,
         * there will be no response from the request.
         */
        $this->assertSame(null, $json);

        /**
         * There were made two calls, one with production and one with trial.
         * Both failed.
         */
        $this->assertCount(2, $history);
    }
}
