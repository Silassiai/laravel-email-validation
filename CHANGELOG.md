# Changelog

All changes to `laravel-email-validation` will be documented in this file

## Unreleased

### What's Changed

* fix: A known mail provider on a globally valid TLD (e.g. `hotmail.es`) is no longer reported as a typo

##  1.0.1 - 2024-09-02

### What's Changed

* improvement: changed `silassiai:seed` command to `silassiai-email-validation:seed`
* fix: Add `fr` and `de` to hotmail allowed extension

##  1.0.0 - 2024-09-02

### What's Changed

* fix: Add character frequency check to improve typo detection accuracy