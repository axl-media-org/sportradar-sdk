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

        $handlerStack = $this->generateMockHandler([
            new Response(200, [], json_encode($response)),
        ]);

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
        $this->assertCount(1, $this->history);
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

        $handlerStack = $this->generateMockHandler([
            new Response(419, ['X-Rate-Limit' => 200]),
            new Response(200, [], json_encode($response)),
        ]);

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
        $this->assertCount(2, $this->history);
    }

    public function test_call_with_non_2xx()
    {
        $handlerStack = $this->generateMockHandler([
            new Response(419, ['X-Rate-Limit' => 200]),
            new Response(419, ['X-Rate-Limit' => 100]),
        ]);

        $json = Sportradar::sport('soccer')
            ->sportEvents()
            ->handler($handlerStack)
            ->call('GET', '/some-endpoint');

        /**
         * Because we have set two keys, both failed,
         * there will be no response from the request.
         */
        $this->assertSame([], $json);

        /**
         * There were made two calls, one with production and one with trial.
         * Both failed.
         */
        $this->assertCount(2, $this->history);
    }

    public function test_pagination()
    {
        $page1Response = [
            'summaries' => [
                ['id' => 1],
                ['id' => 2],
            ],
        ];

        $page2Response = [
            'summaries' => [
                ['id' => 3],
            ],
        ];

        $handlerStack = $this->generateMockHandler([
            new Response(200, ['X-Max-Results' => 3, 'X-Offset' => 0, 'X-Result' => 2], json_encode($page1Response)),
            new Response(419, ['X-Rate-Limit' => 100]),
            new Response(200, ['X-Max-Results' => 3, 'X-Offset' => 2, 'X-Result' => 1], json_encode($page2Response)),
            new Response(200, ['X-Max-Results' => 3, 'X-Offset' => 4, 'X-Result' => 0], json_encode([])),
        ]);

        $summaries = Sportradar::sport('soccer')
            ->sportEvents()
            ->handler($handlerStack)
            ->from('summaries')
            ->limit(2)
            ->call('GET', '/some-endpoint');

        $this->assertTrue($summaries->hasMorePages($summaries));

        $this->assertCount(2, $summaries->getContent());
        $this->assertTrue($summaries->hasMorePages($summaries));

        $summaries = $summaries->next();

        $this->assertCount(1, $summaries->getContent());
        $this->assertFalse($summaries->hasMorePages($summaries));

        $summaries = $summaries->next();

        $this->assertCount(0, $summaries->getContent());
    }

    public function test_pagination_for_parsing()
    {
        $page1Response = [
            'summaries' => [
                ['id' => 1],
                ['id' => 2],
            ],
        ];

        $page2Response = [
            'summaries' => [
                ['id' => 3],
            ],
        ];

        $handlerStack = $this->generateMockHandler([
            new Response(200, ['X-Max-Results' => 3, 'X-Offset' => 0, 'X-Result' => 2], json_encode($page1Response)),
            new Response(200, ['X-Max-Results' => 3, 'X-Offset' => 2, 'X-Result' => 1], json_encode($page2Response)),
            new Response(200, ['X-Max-Results' => 3, 'X-Offset' => 4, 'X-Result' => 0], json_encode([])),
        ]);

        $summaries = Sportradar::sport('soccer')
            ->sportEvents()
            ->handler($handlerStack)
            ->from('summaries')
            ->limit(2)
            ->call('GET', '/some-endpoint');

        while($summaries->parseable()) {
            $summaries = $summaries->next();
        }

        $this->assertCount(3, $this->history);
    }
}
