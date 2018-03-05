# TraderInteractive Filter\Floats

[![Build Status](https://travis-ci.org/traderinteractive/filter-floats-php.svg?branch=master)](https://travis-ci.org/traderinteractive/filter-floats-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/traderinteractive/filter-floats-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/traderinteractive/filter-floats-php/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/traderinteractive/filter-floats-php/badge.svg?branch=master)](https://coveralls.io/github/traderinteractive/filter-floats-php?branch=master)

[![Latest Stable Version](https://poser.pugx.org/traderinteractive/filter-floats/v/stable)](https://packagist.org/packages/traderinteractive/filter-floats)
[![Latest Unstable Version](https://poser.pugx.org/traderinteractive/filter-floats/v/unstable)](https://packagist.org/packages/traderinteractive/filter-floats)
[![License](https://poser.pugx.org/traderinteractive/filter-floats/license)](https://packagist.org/packages/traderinteractive/filter-floats)

[![Total Downloads](https://poser.pugx.org/traderinteractive/filter-floats/downloads)](https://packagist.org/packages/traderinteractive/filter-floats)
[![Daily Downloads](https://poser.pugx.org/traderinteractive/filter-floats/d/daily)](https://packagist.org/packages/traderinteractive/filter-floats)
[![Monthly Downloads](https://poser.pugx.org/traderinteractive/filter-floats/d/monthly)](https://packagist.org/packages/traderinteractive/filter-floats)

A filtering implementation for verifying correct data and performing typical modifications to floats

## Requirements

Requires PHP 7.0 or newer and uses composer to install further PHP dependencies.  See the [composer specification](composer.json) for more details.

## Installation

filter-floats-php can be installed for use in your project using [composer](http://getcomposer.org).
The recommended way of using this library in your project is to add a `composer.json` file to your project.  The following contents would add filter-floats-php as a dependency:
```sh
composer require traderinteractive/filter-floats
```

## Project Build

With a checkout of the code get [Composer](http://getcomposer.org) in your PATH and run:
``sh
composer install
./vendor/bin/phpunit
./vendor/bin/phpcs
```
For more information on our build process, read through out our [Contribution Guidelines](./.github/CONTRIBUTING.md).
