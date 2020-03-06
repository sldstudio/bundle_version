<?php

namespace Solid\VersionChecker\Clients\AppStore;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Solid\VersionChecker\Clients\AppStore\Exceptions\FailedToResolveAppStoreVersionException;
use Solid\VersionChecker\Clients\BundleResolverInterface;
use Solid\VersionChecker\DTOs\VersionQueryResultDTO;

class AppStoreVersionResolver implements BundleResolverInterface
{
    /** @var \GuzzleHttp\ClientInterface */
    protected $client;

    /**
     * VersionQueryService constructor.
     *
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $bundleId
     * @return \Solid\VersionChecker\DTOs\VersionQueryResultDTO
     * @throws \Solid\VersionChecker\Clients\AppStore\Exceptions\FailedToResolveAppStoreVersionException
     */
    public function resolve(string $bundleId): VersionQueryResultDTO
    {
        try {
            $response = $this->client->send(
                new Request('GET', "http://itunes.apple.com/lookup?bundleId=${bundleId}")
            );

            $body = json_decode($response->getBody(), true);

            if (array_key_exists('results', $body) && array_key_exists('resultCount', $body) && $body['resultCount'] > 0) {
                $result = $body['results'][0];

                if (array_key_exists('version', $result)) {
                    return new VersionQueryResultDTO($bundleId, $result['version']);
                }
            }

            throw new FailedToResolveAppStoreVersionException($bundleId, new Exception('Empty payload', 400));
        } catch (GuzzleException $httpException) {
            // TODO: implement more concrete exceptions
            throw new FailedToResolveAppStoreVersionException($bundleId, $httpException);
        } catch (Exception $exception) {
            // TODO: implement more concrete exceptions
            throw new FailedToResolveAppStoreVersionException($bundleId, $exception);
        }
    }
}
