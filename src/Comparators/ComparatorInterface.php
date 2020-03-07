<?php


namespace Solid\VersionChecker\Comparators;


use Solid\VersionChecker\Enums\VersionCompareResultEnum;

interface ComparatorInterface
{
    public function compare(string $originalVersion, string $currentVersion): VersionCompareResultEnum;
}
