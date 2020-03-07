<?php

namespace Solid\VersionChecker\Clients\GooglePlay\Exceptions;

use Exception;
use Throwable;

final class FailedToResolveGooglePlayVersionException extends Exception
{
    /** @var string */
    protected $bundleId;
    /** @var \Throwable */
    private $cause;

    /**
     * FailedToResolveAppStoreVersionException constructor.
     *
     * @param string     $bundleId
     * @param \Throwable $cause
     */
    public function __construct(string $bundleId, Throwable $cause)
    {
        parent::__construct("Failed to resolve $bundleId version from google play page", $cause->getCode(), $cause);
        $this->bundleId = $bundleId;
        $this->cause = $cause;
    }

    /**
     * @return string
     */
    public function getBundleId(): string
    {
        return $this->bundleId;
    }

    /**
     * @return \Throwable
     */
    public function getCause(): Throwable
    {
        return $this->cause;
    }
}
