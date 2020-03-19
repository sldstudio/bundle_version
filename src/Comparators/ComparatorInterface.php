<?php


namespace Solid\VersionChecker\Comparators;


use Solid\VersionChecker\Enums\VersionCompareResultEnum;
use Solid\VersionChecker\Models\VersionInterface;

interface ComparatorInterface
{
    public function compare(VersionInterface $originalVersion, VersionInterface $currentVersion): VersionCompareResultEnum;
}
