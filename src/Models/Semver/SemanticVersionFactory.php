<?php

namespace Solid\VersionChecker\Models\Semver;

use Solid\VersionChecker\Models\Semver\Exceptions\InvalidVersionStringException;

class SemanticVersionFactory
{
    const PATTERN = '/^(?<version>(\d+\.?){1,3})(-(?<note>[\w_.\-]+))?(\+(?<build>\d+))?$/';

    /**
     * @param string $version
     * @return array
     */
    protected function splitVersion(string $version): array
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

    /**
     * @param string $version
     * @return \Solid\VersionChecker\Models\Semver\SemanticVersion
     * @throws \Solid\VersionChecker\Models\Semver\Exceptions\InvalidVersionStringException
     */
    public function fromString(string $version): SemanticVersion
    {
        $isMatched = preg_match(static::PATTERN, $version, $matches);

        if (!$isMatched) {
            throw new InvalidVersionStringException($version);
        }

        list($major, $minor, $patch) = $this->splitVersion($matches['version']);

        return new SemanticVersion(
            (int) $major,
            (int) $minor,
            (int) $patch,
            array_key_exists('build', $matches) ? (int) $matches['build'] : null,
            $matches['note'] ?? null
        );
    }
}
