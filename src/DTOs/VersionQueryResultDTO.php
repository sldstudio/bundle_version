<?php

namespace Solid\VersionChecker\DTOs;

use Solid\VersionChecker\Models\VersionInterface;

class VersionQueryResultDTO
{
    /** @var string */
    protected $bundleId;
    /** @var \Solid\VersionChecker\Models\VersionInterface */
    protected $currentRevision;

    /**
     * VersionQueryResultDTO constructor.
     *
     * @param string $bundleId
     * @param VersionInterface $currentRevision
     */
    public function __construct(string $bundleId, VersionInterface $currentRevision)
    {
        $this->bundleId = $bundleId;
        $this->currentRevision = $currentRevision;
    }

    /**
     * @return string
     */
    public function getBundleId(): string
    {
        return $this->bundleId;
    }

    /**
     * @return VersionInterface
     */
    public function getCurrentRevision(): VersionInterface
    {
        return $this->currentRevision;
    }
}
