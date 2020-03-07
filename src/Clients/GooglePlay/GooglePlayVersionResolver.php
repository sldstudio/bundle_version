<?php

namespace Solid\VersionChecker\Clients\GooglePlay;

use DOMDocument;
use DOMXPath;
use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Solid\VersionChecker\Clients\BundleVersionResolverInterface;
use Solid\VersionChecker\Clients\GooglePlay\Exceptions\FailedToResolveGooglePlayVersionException;
use Solid\VersionChecker\DTOs\VersionQueryResultDTO;

class GooglePlayVersionResolver implements BundleVersionResolverInterface
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
     * @throws \Solid\VersionChecker\Clients\GooglePlay\Exceptions\FailedToResolveGooglePlayVersionException
     */
    public function resolve(string $bundleId): VersionQueryResultDTO
    {
        try {
            $body = $this->client->send(
                new Request('GET', "https://play.google.com/store/apps/details?id=$bundleId&hl=en_GB")
            );

            $dom = new DOMDocument();

            libxml_use_internal_errors(true);
            $dom->loadHTML($body->getBody()->getContents());
            $xpath = new DOMXPath($dom);
            $tags = $xpath->query(".//c-wiz//*[contains(@class, 'htlgb')]");

            if($tags->count() > 0) {
                for($i = 0; $i < $tags->count(); $i++) {
                    /** @var \DOMElement $tag */
                    $tag = $tags->item($i);

                    if(preg_match("/(\d+\.?){2,3}/", $tag->textContent)) {
                        return new VersionQueryResultDTO($bundleId, $tag->textContent);
                    }
                }
            }

            throw new FailedToResolveGooglePlayVersionException($bundleId, new Exception('Failed to resolve version', 400));
        } catch (GuzzleException $httpException) {
            // TODO: implement more concrete exceptions
            throw new FailedToResolveGooglePlayVersionException($bundleId, $httpException);
        } catch (Exception $exception) {
            // TODO: implement more concrete exceptions
            throw new FailedToResolveGooglePlayVersionException($bundleId, $exception);
        }
    }
}
