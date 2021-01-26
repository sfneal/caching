# Caching

[![Packagist PHP support](https://img.shields.io/packagist/php-v/sfneal/caching)](https://packagist.org/packages/sfneal/caching)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sfneal/caching.svg?style=flat-square)](https://packagist.org/packages/sfneal/caching)
[![Build Status](https://travis-ci.com/sfneal/caching.svg?branch=master&style=flat-square)](https://travis-ci.com/sfneal/caching)
[![StyleCI](https://github.styleci.io/repos/288491935/shield?branch=master)](https://github.styleci.io/repos/288491935?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sfneal/caching/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sfneal/caching/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/sfneal/caching.svg?style=flat-square)](https://packagist.org/packages/sfneal/caching)

Traits & interfaces for utilizing cache mechanisms to store frequently retrieved data in Laravel applications.


## Installation

You can install the package via composer:

```bash
composer require sfneal/caching
```

## Usage


### 1. Add caching to an eloquent query
During the first call to `(new CountUnreadInquiriesQuery())->fetch(600)` in a fresh application instance
(or for the first time since flushing the cache) the output of the execute method will be stored in
the Redis cache for 5 minutes (600 seconds).

If another call to `(new CountUnreadInquiriesQuery())->fetch(600)` is made within the next 5 minutes, the
previous output will be retrieved from the Redis cache, forgoing the need to execute a full query to the
database.  In this example the time saved is minimal but time saving become increasingly significant as
the complexity of a query increases.

``` php
# Importing an example model that extends Sfneal/Models/AbstractModels
use App\Models\Inquiry;

# Import Cacheable trait that stores the output of the execute method in a Redis cache using the cacheKey method to set
# the key.  Any serializable output from execute can be stored, in this case we're simply storing an integer
use Sfneal\Caching\Traits\Cacheable;

# Importing AbstractQuery as we're building an Eloquent query cache
use Sfneal\Queries\AbstractQuery;

class CountUnreadInquiriesQuery extends AbstractQuery
{
    use Cacheable;

    /**
     * Retrieve the number of unread Inquiries.
     *
     * @return int
     */
    public function execute(): int
    {
        return Inquiry::query()->whereUnread()->count();
    }

    /**
     * Retrieve the Queries cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        # using AbstractModel::getTableName() to dynamically retrievethetable name to set the cache prefix
        return Inquiry::getTableName().':unread:count';
    }
}
```


## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email stephen.neal14@gmail.com instead of using the issue tracker.

## Credits

- [Stephen Neal](https://github.com/sfneal)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
