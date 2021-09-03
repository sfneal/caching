# Changelog

All notable changes to `caching` will be documented in this file

## 0.1.0 - 2020-08-18
- initial release


## 0.1.1 - 2020-08-20
- add use of RedisCache service


## 0.2.0 - 2020-09-14
- add support for Laravel 8


## 0.2.1 - 2020-09-14
- fix support for Laravel 8


## 0.3.0 - 2020-10-07
- add php 7.0-7.1 backwards compatibility


## 0.4.0 - 2020-11-30
- add php8 compatibility


## 0.4.1 - 2020-12-11
- fix issues with Travis CI php8 tests


## 0.5.0 - 2021-01-26
- cut support php7.0
- add badges to README.md
- bump sfneal/redis-helpers to initial production version


## 1.0.0 - 2021-01-26
- initial production release
- bump sfneal/redis-helpers min version (1.1.0)
- add test suite for testing functionality
- add use of sfneal/redis-helpers config settings
- update documentation


## 1.1.0 - 2021-02-02
- bump min sfneal/redis-helpers version


## 1.2.0 - 2021-02-10
- make IsCacheable trait with cacheKey() abstract method & isCached() public method
- optimize return type hinting


## 1.3.0 - 2021-04-07
- bump min sfneal/redis-helpers package version to v1.3 to avoid conflicts with sfneal/actions v2.0


## 1.3.1 - 2021-04-28
- add use of `josiasmontag/laravel-redis-mock` for redis mocking
- add test methods to `CacheableTest`
- optimize Travis CI config & enable code coverage uploading

 
## 1.3.2 - 2021-08-19
- add use of dataProvider in `CacheableTest`
- refactor `TodaysDateHash` mock test class to `DateHash`
- refactor test classes into `Assets`, `Unit` & `Feature` namespaces


## 2.0.0 - 2021-08-31
- bump sfneal/redis-helpers min version to v1.4
- fix issues surrounding `invalidateCache()` methods not deleting child keys
- fix default cache key 'id suffix' delimiter to be ':' instead of '#' due to issues with mock & other redis clients


## 2.0.1 - 2021-08-31
- add support for sfneal/redis-helper v2.0
- cut use of removed `RedisCache` methods


## 2.1.0 - 2021-09-03
- fix `Cacheable::invalidateCache()` method to return an array of deleted keys for easier debugging
- add improved assertions to `CacheInvalidationTest`


## 2.1.1 - 2021-09-03
- add explicit deleting of the primary cache key in `Cacheable::invalidateCache()` method
