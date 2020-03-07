<?php

namespace Solid\VersionChecker\Comparators;

use Solid\VersionChecker\Enums\VersionCompareResultEnum;

class SemverComparator implements ComparatorInterface
{
    protected function hydrateVersionVector(string $version)
    {
        $parts = explode('.', $version);

        if (array_key_exists(0, $parts)) {
            $major = $parts[0];
        } else {
            $major = 0;
        }

        if (array_key_exists(1, $parts)) {
            $minor = $parts[1];
        } else {
            $minor = 0;
        }

        if (array_key_exists(2, $parts)) {
            $patch = $parts[2];
        } else {
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
