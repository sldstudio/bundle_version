<?php

namespace Solid\VersionChecker\Clients;

use Solid\VersionChecker\DTOs\VersionQueryResultDTO;

interface BundleResolverInterface
{
    public function resolve(string $bundleId): VersionQueryResultDTO;
}
