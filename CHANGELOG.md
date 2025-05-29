# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2024-12-19

### Added
- **Major RequestHelper Enhancement**: Added 30+ new methods for comprehensive HTTP request analysis
  - Environment detection (isCli, isHttps, isAjax, isBot, isMobile, etc.)
  - HTTP method analysis (isGet, isPost, isPut, isDelete, etc.)
  - Request type detection (isJson, isXml, isForm, isMultipart)
  - Client information (getUserAgent, getClientIp, getReferer)
  - Content analysis (getContentType, getContentLength, getAcceptedLanguages)
  - Header management and security validation
  - 47 comprehensive tests with 107 assertions

- **Major UrlHelper Enhancement**: Added 30+ new methods for comprehensive URL manipulation
  - URL parsing and validation (isValid, isAbsolute, isRelative, getScheme, etc.)
  - URL manipulation (addQuery, removeQuery, setFragment, normalize)
  - Path manipulation (getPathSegments, addPathSegment, removePath)
  - Domain and host utilities (getDomain, getSubdomain, isLocalhost)
  - Encoding and decoding utilities
  - 64 total tests (28 new) with 168 assertions

- **Complete HexHelper Testing**: Added 15 comprehensive test methods with 116 assertions
  - Tests for brightness adjustment with positive/negative values
  - Support for 3-character and 6-character hex codes
  - Edge cases and boundary conditions testing
  - Color format normalization verification

- **New NetworkHelper**: Complete network utility class
  - IP address validation and manipulation
  - Network range calculations
  - DNS lookup utilities
  - Port connectivity testing

- **New HTML Helpers**: Enhanced HTML generation capabilities
  - Advanced form element generation
  - Improved attribute handling
  - Better HTML escaping and security

- **Enhanced AttributesHelper**: Improved HTML attribute management
  - Factory methods for creating attributes
  - Validation and rendering capabilities
  - Immutability patterns
  - 40 test methods with 120 assertions

- **Complete Test Coverage**: Massive testing improvements across all helpers
  - FormHelper: 56 comprehensive test methods with 211 assertions
  - CsvHelper: 35 comprehensive test methods with 823 lines of coverage
  - EmailHelper: Comprehensive tests with improved logic
  - BootstrapHelper: 23 test methods with 167 assertions
  - UrlHelper: Complete test coverage with 36 foundational tests

### Enhanced
- **EmailHelper**: Fixed nested arrays and multi-delimiter bugs
- **CsvHelper**: Integrated IOHelper for better file management
- **Documentation**: Updated README with comprehensive examples for all enhanced helpers
- **Code Quality**: Added comprehensive PHPDoc comments and @test/@covers annotations

### Fixed
- RequestHelper: Fixed CLI mode detection during PHPUnit execution
- UrlHelper: Adjusted toRelative() method for better edge case handling
- EmailHelper: Resolved nested array processing issues

### Infrastructure
- CI: Enhanced GitHub Actions to run on dev branch pushes and PRs
- Documentation: Improved composer.json description and keywords
- Testing: Achieved 523 total tests with 1,804 assertions across the entire project

## [1.2.0] - 2024-03-XX

### Added
- Support for PHP 8.3
- Comprehensive PHPDoc comments in test files
- Improved test documentation and coverage
- Added @test and @covers annotations to all test methods

### Changed
- Renamed master branch to main
- Updated branch alias in composer.json
- Improved exception handling in DateHelper for PHP 8.3 compatibility

### Fixed
- Fixed DateHelper::isDateTime() method for PHP 8.3 compatibility

## [1.0.0] - Previous Release

### Added
- Initial release with core helper classes
- Array manipulation utilities
- Date handling utilities
- String manipulation utilities
- HTML generation utilities
- IO operations utilities
- JSON validation utilities
- Number formatting utilities
- Random value generation utilities
- Value type checking utilities 