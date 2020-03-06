<?php

namespace Solid\VersionChecker\DTOs;

class VersionQueryResultDTO
{
    /** @var string */
    protected $bundleId;
    /** @var string */
    protected $currentRevision;

    /**
     * VersionQueryResultDTO constructor.
     *
     * @param string $bundleId
     * @param string $currentRevision
     */
    public function __construct(string $bundleId, string $currentRevision)
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
     * @return string
     */
    public function getCurrentRevision(): string
    {
        return $this->currentRevision;
    }
}
