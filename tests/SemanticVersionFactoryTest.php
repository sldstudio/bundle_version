<?php

use PHPUnit\Framework\TestCase;
use Solid\VersionChecker\Models\Semver\Exceptions\InvalidVersionStringException;
use Solid\VersionChecker\Models\Semver\SemanticVersionFactory;

class SemanticVersionFactoryTest extends TestCase
{
    /** @var \Solid\VersionChecker\Models\Semver\SemanticVersionFactory */
    protected $factory;

    /**
     * SemanticVersionFactoryTest constructor.
     */
    public function __construct()
    {
        parent::__construct('Semantic version factory test');
        $this->factory = new SemanticVersionFactory();
    }

    /**
     * @throws \Solid\VersionChecker\Models\Semver\Exceptions\InvalidVersionStringException
     */
    public function testSimpleVersion()
    {
        $version = '2.1.5';
        $semver = $this->factory->fromString($version);

        $this->assertEquals(2, $semver->getMajor());
        $this->assertEquals(1, $semver->getMinor());
        $this->assertEquals(5, $semver->getPatch());
    }

    public function testVersionWithBuildNumber()
    {
        $version = '3.5.7+15';
        $semver = $this->factory->fromString($version);

        $this->assertEquals(3, $semver->getMajor());
        $this->assertEquals(5, $semver->getMinor());
        $this->assertEquals(7, $semver->getPatch());
        $this->assertEquals(15, $semver->getBuild());
    }

    public function testVersionWithNotes()
    {
        $version = '2.3.1-gm';
        $semver = $this->factory->fromString($version);

        $this->assertEquals(2, $semver->getMajor());
        $this->assertEquals(3, $semver->getMinor());
        $this->assertEquals(1, $semver->getPatch());
        $this->assertEquals('gm', $semver->getNote());
    }

    public function testVersionWithNotesAndBuild()
    {
        $version = '1.1.5-rc1+3';
        $semver = $this->factory->fromString($version);

        $this->assertEquals(1, $semver->getMajor());
        $this->assertEquals(1, $semver->getMinor());
        $this->assertEquals(5, $semver->getPatch());
        $this->assertEquals('rc1', $semver->getNote());
        $this->assertEquals(3, $semver->getBuild());
    }

    public function testInvalidVersion()
    {
        $this->expectException(InvalidVersionStringException::class);
        $version = 'qq';
        $this->factory->fromString($version);
    }
}
