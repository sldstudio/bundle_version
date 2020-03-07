<?php

namespace Solid\VersionChecker\Clients;

use Solid\VersionChecker\DTOs\VersionQueryResultDTO;

interface BundleVersionResolverInterface
{
    public function resolve(string $bundleId): VersionQueryResultDTO;
}
