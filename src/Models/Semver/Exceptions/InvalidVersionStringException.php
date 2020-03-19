<?php

namespace Solid\VersionChecker\Models\Semver\Exceptions;

use Exception;

class InvalidVersionStringException extends Exception
{
    /** @var string */
    protected $string;

    /**
     * InvalidVersionStringException constructor.
     *
     * @param string $string
     */
    public function __construct(string $string)
    {
        parent::__construct('Invalid semantic version string given');
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
    }
}
