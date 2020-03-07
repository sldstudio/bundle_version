<?php

use PHPUnit\Framework\TestCase;
use Solid\VersionChecker\Comparators\SemverComparator;
use Solid\VersionChecker\Enums\VersionCompareResultEnum;

class SemverComparatorTest extends TestCase
{
    /** @var \Solid\VersionChecker\Comparators\SemverComparator */
    protected $comparator;

    /**
     * SemverComparatorTest constructor.
     */
    public function __construct()
    {
        parent::__construct('Semver version comparator');
        $this->comparator = new SemverComparator();
    }

    public function testMajorReleaseChange()
    {
        $result = $this->comparator->compare('2.0.0', '1.0.0');
        $this->assertTrue($result->is(VersionCompareResultEnum::MAJOR_CHANGE));

        $result = $this->comparator->compare('2', '3');
        $this->assertTrue($result->is(VersionCompareResultEnum::MAJOR_CHANGE));
    }

    public function testMinorReleaseChange()
    {
        $result = $this->comparator->compare('2.1.0', '2.0.0');
        $this->assertTrue($result->is(VersionCompareResultEnum::MINOR_CHANGE));

        $result = $this->comparator->compare('2.5.0', '2.1');
        $this->assertTrue($result->is(VersionCompareResultEnum::MINOR_CHANGE));
    }

    public function testPatchChange()
    {
        $result = $this->comparator->compare('2.1.2', '2.1.1');
        $this->assertTrue($result->is(VersionCompareResultEnum::PATCH));

        $result = $this->comparator->compare('2.1.5', '2.1');
        $this->assertTrue($result->is(VersionCompareResultEnum::PATCH));
    }

    public function testSame()
    {
        $result = $this->comparator->compare('2.1.0', '2.1.0');
        $this->assertTrue($result->is(VersionCompareResultEnum::SAME));

        $result = $this->comparator->compare('2', '2');
        $this->assertTrue($result->is(VersionCompareResultEnum::SAME));

        $result = $this->comparator->compare('2.1', '2.1');
        $this->assertTrue($result->is(VersionCompareResultEnum::SAME));
    }


}
