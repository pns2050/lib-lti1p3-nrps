# LTI 1.3 NRPS Library

[![Latest Version](https://img.shields.io/github/tag/oat-sa/lib-lti1p3-nrps.svg?style=flat&label=release)](https://github.com/oat-sa/lib-lti1p3-nrps/tags)
[![License GPL2](http://img.shields.io/badge/licence-GPL%202.0-blue.svg)](http://www.gnu.org/licenses/gpl-2.0.html)
[![Build Status](https://travis-ci.org/oat-sa/lib-lti1p3-nrps.svg?branch=master)](https://travis-ci.org/oat-sa/lib-lti1p3-nrps)
[![Coverage Status](https://coveralls.io/repos/github/oat-sa/lib-lti1p3-nrps/badge.svg?branch=master)](https://coveralls.io/github/oat-sa/lib-lti1p3-nrps?branch=master)
[![Packagist Downloads](http://img.shields.io/packagist/dt/oat-sa/lib-lti1p3-nrps.svg)](https://packagist.org/packages/oat-sa/lib-lti1p3-nrps)

> PHP library for [LTI 1.3 Names and Role Provisioning Services](https://www.imsglobal.org/spec/lti-nrps/v2p0) implementations as platforms and / or as tools, based on [LTI 1.3 Core library](https://github.com/oat-sa/lib-lti1p3-core).

# Table of contents

- [Specifications](#specifications)
- [Installation](#installation)
- [Tutorials](#tutorials)
- [Tests](#tests)

## Specifications

- [IMS LTI 1.3 Names and Role Provisioning Services](https://www.imsglobal.org/spec/lti-nrps/v2p0)
- [IMS LTI 1.3 Core](http://www.imsglobal.org/spec/lti/v1p3)
- [IMS Security](https://www.imsglobal.org/spec/security/v1p0)

## Installation

```console
$ composer require oat-sa/lib-lti1p3-nrps
```

## Tutorials

You can then find below usage tutorials, presented by topics.

### Configuration

- how to [configure the underlying LTI 1.3 Core library](https://github.com/oat-sa/lib-lti1p3-core#quick-start).

### Tool

- how to [use the NRPS library as a tool](doc/tool.md)

### Platform

- how to [use the NRPS library as a platform](doc/platform.md)

## Tests

To run tests:

```console
$ vendor/bin/phpunit
```
**Note**: see [phpunit.xml.dist](phpunit.xml.dist) for available test suites.