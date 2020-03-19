<?php

namespace Solid\VersionChecker\Models\Semver\Comparators;

use Exception;
use Solid\VersionChecker\Models\VersionInterface;

class IncompatibleVersionComparisonException extends Exception
{
    /** @var \Solid\VersionChecker\Models\VersionInterface */
    protected $one;
    /** @var \Solid\VersionChecker\Models\VersionInterface */
    protected $another;

    /**
     * IncompatibleCompareValues constructor.
     *
     * @param \Solid\VersionChecker\Models\VersionInterface $one
     * @param \Solid\VersionChecker\Models\VersionInterface $another
     */
    public function __construct(VersionInterface $one, VersionInterface $another)
    {
        parent::__construct('Incompatible version model comparison');

        $this->one = $one;
        $this->another = $another;
    }


}
