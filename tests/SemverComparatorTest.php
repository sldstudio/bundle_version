<?php

use PHPUnit\Framework\TestCase;
use Solid\VersionChecker\Enums\VersionCompareResultEnum;
use Solid\VersionChecker\Models\Semver\Comparators\SemverComparator;
use Solid\VersionChecker\Models\Semver\SemanticVersionFactory;

class SemverComparatorTest extends TestCase
{
    /** @var \Solid\VersionChecker\Models\Semver\Comparators\SemverComparator */
    protected $comparator;
    /** @var \Solid\VersionChecker\Models\Semver\SemanticVersionFactory */
    private $factory;

    /**
     * SemverComparatorTest constructor.
     */
    public function __construct()
    {
        parent::__construct('Semver version comparator');
        $this->comparator = new SemverComparator();
        $this->factory = new SemanticVersionFactory();
    }

    public function testMajorReleaseChange()
    {
        $result = $this->comparator->compare(
            $this->factory->fromString('2.0.0'),
            $this->factory->fromString('1.0.0')
        );

        $this->assertTrue($result->is(VersionCompareResultEnum::BREAKING));

        $result = $this->comparator->compare(
            $this->factory->fromString('2.0'),
            $this->factory->fromString('1.1')
        );

        $this->assertTrue($result->is(VersionCompareResultEnum::BREAKING));
    }

    public function testMinorReleaseChange()
    {
        $result = $this->comparator->compare(
            $this->factory->fromString('2.1.0'),
            $this->factory->fromString('2.0')
        );

        $this->assertTrue($result->is(VersionCompareResultEnum::MINOR));

        $result = $this->comparator->compare(
            $this->factory->fromString('2.5.3'),
            $this->factory->fromString('2.1')
        );

        $this->assertTrue($result->is(VersionCompareResultEnum::MINOR));
    }

    public function testPatchChange()
    {
        $result = $this->comparator->compare(
            $this->factory->fromString('2.1'),
            $this->factory->fromString('2.1.1')
        );
        $this->assertTrue($result->is(VersionCompareResultEnum::PATCH));
    }

    public function testSame()
    {
        $result = $this->comparator->compare(
            $this->factory->fromString('2.1.0'),
            $this->factory->fromString('2.1.0')
        );

        $this->assertTrue($result->is(VersionCompareResultEnum::SAME));

        $result = $this->comparator->compare(
            $this->factory->fromString('2'),
            $this->factory->fromString('2')
        );

        $this->assertTrue($result->is(VersionCompareResultEnum::SAME));

        $result = $this->comparator->compare(
            $this->factory->fromString('2.1'),
            $this->factory->fromString('2.1')
        );

        $this->assertTrue($result->is(VersionCompareResultEnum::SAME));
    }


}
