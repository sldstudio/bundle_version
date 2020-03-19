<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Solid\VersionChecker\Clients\AppStore\AppStoreVersionResolver;
use Solid\VersionChecker\Clients\AppStore\Exceptions\FailedToResolveAppStoreVersionException;

class AppStoreVersionResolverTest extends TestCase
{
    /** @var AppStoreVersionResolver */
    protected $resolver;

    /**
     * AppStoreResolverTest constructor.
     */
    public function __construct()
    {
        parent::__construct('App store resolver');
        $this->resolver = new AppStoreVersionResolver(new Client);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Solid\VersionChecker\Clients\AppStore\Exceptions\FailedToResolveAppStoreVersionException
     */
    public function testAppStoreLookup()
    {
        $bundle = 'com.apple.stocks';
        $version = $this->resolver->resolve($bundle);

        $this->assertSame($bundle, $version->getBundleId());
        $this->assertIsString($version->getCurrentRevision()->toString());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Solid\VersionChecker\Clients\AppStore\Exceptions\FailedToResolveAppStoreVersionException
     */
    public function testFailedAppStoreLookup()
    {
        $this->expectException(FailedToResolveAppStoreVersionException::class);
        $this->resolver->resolve('gibberish');
    }
}
