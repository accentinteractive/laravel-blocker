# Changelog

All notable changes to `laravel-blocker` will be documented in this file

## 1.0.0 - 2023-07-10

### Added
- Laravel 10 support

## 0.2.0 - 2023-01-09

### Added
- Created cache store implementation of BlockedIpStore facade. 
- Set BlockedIpStoreCache as default BlockedIpStore.

### Changed
- Moved database store to repository
- Bugfix : type casting in middleware

## 0.1.0 - 2023-01-08

- initial release 

### Added
- Service Provider
- Configuration
- Malicious URL matcher (`LaravelBlocker` facade)
- Malicious User Agents matcher
- Middleware that blocks users that visit a malicious URL or have a malicious user agent 
- Exceptions 
- Database storage of blocked IPs
- README
