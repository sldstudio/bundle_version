<?php

namespace Solid\VersionChecker\Models\Semver;

use Solid\VersionChecker\Models\VersionInterface;

class SemanticVersion implements VersionInterface
{
    /** @var int  */
    protected $major;
    /** @var int  */
    protected $minor;
    /** @var int  */
    protected $patch;
    /** @var int  */
    protected $build;
    /** @var string  */
    protected $note;

    /**
     * SemanticVersion constructor.
     *
     * @param int $major
     * @param int $minor
     * @param int $patch
     * @param int $build
     * @param string $note
     */
    public function __construct(int $major, int $minor = 0, int $patch = 0, int $build = null, string $note = null)
    {
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
        $this->build = $build;
        $this->note = $note;
    }

    /**
     * @return int
     */
    public function getMajor(): int
    {
        return $this->major;
    }

    /**
     * @return int
     */
    public function getMinor(): int
    {
        return $this->minor;
    }

    /**
     * @return int
     */
    public function getPatch(): int
    {
        return $this->patch;
    }

    /**
     * @return int|null
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * @return string|null
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        $string = sprintf('%d.%d.%d', $this->major, $this->minor, $this->patch);

        if ($this->build) {
            $string .= sprintf('+%d', $this->build);
        }

        if ($this->note) {
            $string .= sprintf('-%s', $this->note);
        }

        return $string;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
