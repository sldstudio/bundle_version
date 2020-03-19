<?php

namespace Solid\VersionChecker\Models\Semver\Comparators;

use Solid\VersionChecker\Comparators\ComparatorInterface;
use Solid\VersionChecker\Enums\VersionCompareResultEnum;
use Solid\VersionChecker\Models\Semver\SemanticVersion;
use Solid\VersionChecker\Models\VersionInterface;

class SemverComparator implements ComparatorInterface
{
    /**
     * @param \Solid\VersionChecker\Models\VersionInterface $originalVersion
     * @param \Solid\VersionChecker\Models\VersionInterface $currentVersion
     * @return \Solid\VersionChecker\Enums\VersionCompareResultEnum
     * @throws \Solid\VersionChecker\Models\Semver\Comparators\IncompatibleVersionComparisonException
     */
    public function compare(VersionInterface $originalVersion, VersionInterface $currentVersion): VersionCompareResultEnum
    {
        if(!($originalVersion instanceof SemanticVersion && $currentVersion instanceof SemanticVersion)) {
            throw new IncompatibleVersionComparisonException($originalVersion, $currentVersion);
        }

        if ($originalVersion->getMajor() !== $currentVersion->getMajor() ||
            $originalVersion->getNote() !== $currentVersion->getNote()) {
            return new VersionCompareResultEnum(VersionCompareResultEnum::BREAKING);
        }

        if ($originalVersion->getMinor() !== $currentVersion->getMinor() ||
            $originalVersion->getBuild() !== $currentVersion->getBuild()) {
            return new VersionCompareResultEnum(VersionCompareResultEnum::MINOR);
        }

        if ($originalVersion->getPatch() !== $currentVersion->getPatch()) {
            return new VersionCompareResultEnum(VersionCompareResultEnum::PATCH);
        }

        return new VersionCompareResultEnum(VersionCompareResultEnum::SAME);
    }
}
