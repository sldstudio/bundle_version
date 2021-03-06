<?php

namespace Solid\VersionChecker\Enums;

use InvalidArgumentException;

class VersionCompareResultEnum
{
    const BREAKING = 'major';
    const MINOR = 'minor';
    const PATCH = 'patch';
    const SAME = 'same';

    /** @var string */
    protected $value;

    /**
     * VersionQueryResultEnum constructor.
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        switch ($type) {
            case static::BREAKING:
            case static::MINOR:
            case static::PATCH:
            case static::SAME:
                $this->value = $type;
                break;

            default:
                throw new InvalidArgumentException("Unsupported enum value ${type}");
        }
    }

    /**
     * @param string $type
     * @return bool
     */
    public function is(string $type): bool
    {
        return $this->value === $type;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
