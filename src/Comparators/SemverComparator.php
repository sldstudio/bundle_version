<?php

namespace Solid\VersionChecker\Comparators;

use Solid\VersionChecker\Enums\VersionCompareResultEnum;

class SemverComparator implements ComparatorInterface
{
    protected function hydrateVersionVector(string $version)
    {
        list($major, $minor, $patch) = explode('.', $version);

        if ($major === null) {
            $major = 0;
        }

        if ($minor === null) {
            $minor = 0;
        }

        if ($patch === null) {
            $patch = 0;
        }

        return [$major, $minor, $patch];
    }

    public function compare(string $originalVersion, string $currentVersion): VersionCompareResultEnum
    {
        $aOriginal = $this->hydrateVersionVector($originalVersion);
        $aCurrent = $this->hydrateVersionVector($currentVersion);

        if ($aOriginal[0] !== $aCurrent[0]) {
            return new VersionCompareResultEnum(VersionCompareResultEnum::MAJOR_CHANGE);
        }

        if ($aOriginal[1] !== $aCurrent[1]) {
            return new VersionCompareResultEnum(VersionCompareResultEnum::MINOR_CHANGE);
        }

        if ($aOriginal[2] !== $aCurrent[2]) {
            return new VersionCompareResultEnum(VersionCompareResultEnum::PATCH);
        }

        return new VersionCompareResultEnum(VersionCompareResultEnum::SAME);
    }
}
