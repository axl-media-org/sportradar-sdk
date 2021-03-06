<?php

namespace AxlMedia\SportradarSdk;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Arr;

abstract class Client
{
    /**
     * The API keys pool for the serivce.
     *
     * @var array
     */
    protected static $apiKeys = [];

    /**
     * The response type.
     * Currently available: xml, json.
     *
     * @var string
     */
    protected $responseType = 'json';

    /**
     * The numbers format for odds.
     * Available: eu, uk, us.
     *
     * @var string
     */
    protected $oddsFormat = 'eu';

    /**
     * The API domain.
     * Available: us, com.
     *
     * @var string
     */
    protected $domain = 'com';

    /**
     * The league group.
     * Available: eu, am, as, ntl, other, global.
     *
     * @var string
     */
    protected $leagueGroup = 'global';

    /**
     * The language.
     *
     * @var string
     */
    protected $language = 'en';

    /**
     * For odds. Defines the package.
     * Available: us, row.
     *
     * @var string
     */
    protected $package = 'row';

    /**
     * The URL placeholder.
     *
     * @var string|null
     */
    protected $apiUrlPlaceholder;

    /**
     * Debug mode.
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * The handler used to mock Guzzle.
     *
     * @var mixed
     */
    protected $handler;

    /**
     * Access the key directly from the response,
     * instead of passing the whole response.
     *
     * @var string
     */
    protected $from;

    /**
     * The offset for results.
     *
     * @var int
     */
    protected $offset = 0;

    /**
     * The limit of results.
     *
     * @var int
     */
    protected $limit = 500;

    /**
     * Set up a pool of keys, on demand.
     *
     * @param  array  $keys
     * @return void
     */
    public static function keys(array $keys = [])
    {
        static::$apiKeys = $keys;
    }

    /**
     * Change the response type.
     * Possible values: json, xml.
     *
     * @param  string  $responseType
     * @return $this
     */
    public function type(string $responseType)
    {
        $this->responseType = $responseType;

        return $this;
    }

    /**
     * Change the domain on which requests will be on.
     * Possible values: com, us.
     *
     * @param  string  $domain
     * @return $this
     */
    public function domain(string $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Change the league group.
     * Possible values: eu, am, as, ntl, other, global.
     *
     * @param  string  $leagueGroup
     * @return $this
     */
    public function league(string $leagueGroup)
    {
        $this->leagueGroup = $leagueGroup;

        return $this;
    }

    /**
     * Change the language.
     *
     * @param  string  $language
     * @return $this
     */
    public function language(string $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Change the package for odds.
     * Possible values: us, row.
     *
     * @param  string  $package
     * @return $this
     */
    public function package(string $package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Enable debugging.
     *
     * @return $this
     */
    public function debug()
    {
        $this->debug = true;

        return $this;
    }

    /**
     * Change the odds format.
     * Possible values: eu, uk, us.
     *
     * @param  string  $oddsFormat
     * @return $this
     */
    public function oddsFormat(string $oddsFormat)
    {
        $this->oddsFormat = $oddsFormat;

        return $this;
    }

    /**
     * Define the placeholder for variables.
     *
     * @param  string  $placeholder
     * @return $this
     */
    public function placeholder(string $placeholder)
    {
        $this->apiUrlPlaceholder = $placeholder;

        return $this;
    }

    /**
     * Set the handler for Guzzle.
     *
     * @param  mixed  $handler
     * @return $this
     */
    public function handler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Specify the key which should be retrieved
     * upon response.
     *
     * @param  string  $from
     * @return $this
     */
    public function from(string $from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Apply offset to the request.
     *
     * @param  int  $offset
     * @return $this
     */
    public function offset(int $offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * Apply result limiting to the request.
     *
     * @param  int  $limit
     * @return $this
     */
    public function limit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Specify the client to go further with the
     * offset by a specific amount or by current limit.
     *
     * @param  int|null  $amount
     * @return $this
     */
    public function next(int $amount = null)
    {
        return $this->offset($this->offset + ($amount ?: $this->limit));
    }

    /**
     * Make an API call.
     *
     * @param  string  $method
     * @param  string  $endpoint
     * @return array|null
     */
    public function call(string $method, string $endpoint)
    {
        $callableUrls = $this->urls($endpoint);

        if ($this->debug) {
            return $callableUrls;
        }

        $client = new \GuzzleHttp\Client([
            'handler' => $this->handler,
        ]);

        $response = collect($callableUrls)->reduce(function ($response, $url) use ($client, $method, $endpoint) {
            if ($response) {
                return $response;
            }

            try {
                $response = $client->request($method, $url);

                $json = json_decode(
                    $response->getBody()->__toString(),
                    true
                );
            } catch (ClientException | Exception $e) {
                return [];
            }

            if ($paginator = $this->paginator($response, $json, $url, $method, $endpoint)) {
                return $paginator;
            }

            return $this->from
                ? Arr::get($json, $this->from)
                : $json;
        }, []);

        return $response;
    }

    /**
     * Get the URLs on which the request will be made.
     *
     * @param  string  $endpoint
     * @return array
     */
    public function urls(string $endpoint): array
    {
        if (! $placeholderUrl = $this->apiUrlPlaceholder) {
            return [];
        }

        $urls = collect(static::$apiKeys)->map(function ($key, $accessLevel) {
            return [
                'key' => $key,
                'access_level' => $accessLevel,
            ];
        })->reduce(function ($urls, $keyDetails) use ($endpoint, $placeholderUrl) {
            $placeholders = [
                'access_level' => $keyDetails['access_level'],
                'league_group' => $this->leagueGroup,
                'language_code' => $this->language,
                'package' => $this->package,
                'endpoint' => $endpoint,
                'odds_format' => $this->oddsFormat,
                'format' => $this->responseType,
            ];

            $url = $this->replacePlaceholdersInUrl(
                $placeholders,
                $placeholderUrl
            );

            $urls[] = "{$this->getApiBaseUrl()}{$url}?api_key={$keyDetails['key']}&offset={$this->offset}&limit={$this->limit}";

            return $urls;
        }, []);

        return $urls;
    }

    /**
     * Replace the key-value placeholders in a given URL.
     *
     * @param  array  $placeholders
     * @param  string  $url
     * @return string
     */
    protected function replacePlaceholdersInUrl(array $placeholders, string $url): string
    {
        foreach ($placeholders as $key => $value) {
            $url = str_replace("{{$key}}", $value, $url);
        }

        return $url;
    }

    /**
     * Get the Base API URL.
     *
     * @return string
     */
    protected function getApiBaseUrl(): string
    {
        $domain = $this->domain;

        return "https://api.sportradar.{$domain}";
    }

    /**
     * Get the headers from the Guzzle response.
     *
     * @param  mixed  $response
     * @return array
     */
    protected function getHeaders($response): array
    {
        return collect($response->getHeaders())->map(function ($value, $key) {
            return ((int) $value[0] == $value[0])
                ? (int) $value[0]
                : $value[0];
        })->toArray();
    }

    /**
     * Get the paginator, if any.
     *
     * @param  mixed  $response
     * @param  array|null  $json
     * @param  string  $url
     * @param  string  $method
     * @param  string  $endpoint
     * @return PaginatedResult|null
     */
    protected function paginator($response, $json, string $url, string $method, string $endpoint)
    {
        $headers = $this->getHeaders($response);

        if (! $maxResults = $headers['X-Max-Results'] ?? false) {
            return;
        }

        $offset = $headers['X-Offset'] ?? 0;
        $currentPageResults = $headers['X-Result'] ?? 0;

        $paginator = new Paginator(
            $this->from ? Arr::get($json, $this->from) : ($json ?: []),
            $maxResults,
            $this->limit,
            (int) floor($offset / $this->limit) + 1,
            ['pageName' => 'page']
        );

        $paginator->setPath($url);

        return new PaginatedResult($paginator, $method, $endpoint, $this);
    }
}
