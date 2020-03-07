# Application bundle version checker tools

[![Build Status](https://travis-ci.com/ica4c/bundle_version.svg?branch=master)](https://travis-ci.org/ica4c/bundle_version)

Small tool set which enables you to check currently deployed GooglePlay and AppStore application revision

## Installation

`composer require solid/bundle_version`

## Usage

Each store has separate `BundleVersionResolverInterface` concrete
i.e `GooglePlayVersionResolver`, `AppStoreVersionResolver`, you simply need to provide
`$bundleId` into it's `resolve($bundleId)` method. On success you will receive
`VersionQueryResultDTO` result containing `$bundleId` and `$currentRevision` values or
instance of `FailedToResolveGooglePlayVersionException` on exception

### GooglePlay sample

```php
use Solid\VersionChecker\Clients\GooglePlay\Exceptions\FailedToResolveGooglePlayVersionException;
use Solid\VersionChecker\Clients\GooglePlay\GooglePlayVersionResolver;
use GuzzleHttp\Client;

try {
    $resolver = new GooglePlayVersionResolver(new Client);
    $version = $this->resolver->resolve('com.app.example');

    echo $version->getBundleId() . ':' . $version->getCurrentRevision();
} catch(FailedToResolveGooglePlayVersionException $e) {
    echo 'Failed to resolve version';
}
```

which will output `com.app.example:1.0.0` or `Failed to resolve version` in case of error

### AppStore sample

```php
use Solid\VersionChecker\Clients\AppStore\AppStoreVersionResolver;
use Solid\VersionChecker\Clients\AppStore\Exceptions\FailedToResolveAppStoreVersionException;
use GuzzleHttp\Client;

try {
    $resolver = new AppStoreVersionResolver(new Client);
    $version = $this->resolver->resolve('com.app.example');

    echo $version->getBundleId() . ':' . $version->getCurrentRevision();
} catch(FailedToResolveAppStoreVersionException $e) {
    echo 'Failed to resolve version';
}
```

which will output `com.app.example:1.0.0` or `Failed to resolve version` in case of error

## Version comparator

Package also provides ready to use version compare algorithm which enables you to perform version checks

```php
use Solid\VersionChecker\Clients\GooglePlay\Exceptions\FailedToResolveGooglePlayVersionException;
use Solid\VersionChecker\Clients\GooglePlay\GooglePlayVersionResolver;
use Solid\VersionChecker\Clients\AppStore\AppStoreVersionResolver;
use Solid\VersionChecker\Clients\AppStore\Exceptions\FailedToResolveAppStoreVersionException;
use Solid\VersionChecker\Comparators\SemverComparator;
use Solid\VersionChecker\Enums\VersionCompareResultEnum;
use GuzzleHttp\Client;

try {
    $httpClient = new Client;
    $appStoreResolver = new AppStoreVersionResolver($httpClient);
    $googlePlayResolver = new GooglePlayVersionResolver($httpClient);

    $appStoreVersion = $this->resolver->resolve('com.app.example');
    $googlePlayVersion = $this->resolver->resolve('com.app.example');
    $comparator = new SemverComparator();
    $versionCompareResult = $comparator->compare($appStoreVersion->getCurrentRevision(), $googlePlayVersion->getCurrentRevision())

    if($versionCompareResult->is(VersionCompareResultEnum::MAJOR_CHANGE)) {
       echo 'App store has newer major release than play store';
    } else if($versionCompareResult->is(VersionCompareResultEnum::MINOR_CHANGE)) {
       echo 'App store has newer minor release than play store';
    } else if($versionCompareResult->is(VersionCompareResultEnum::PATCH)) {
       echo 'App store has newer patch release than play store';
    } else {
       echo 'App store and google play share same version';
    }
} catch(FailedToResolveAppStoreVersionException $e) {
    echo 'Failed to resolve app store version';
} catch(FailedToResolveGooglePlayVersionException $e) {
     echo 'Failed to resolve google play version';
}
```
