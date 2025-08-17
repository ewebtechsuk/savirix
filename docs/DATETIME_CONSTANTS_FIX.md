# DateTimeInterface::SECONDS_PER_HOUR Fix

## Issue
The PHP constant `DateTimeInterface::SECONDS_PER_HOUR` does not exist in PHP's `DateTimeInterface` class. 
Attempting to use this constant will result in a fatal error:

```
Error: Undefined constant DateTimeInterface::SECONDS_PER_HOUR
```

## Solution
Replace all usages of `DateTimeInterface::SECONDS_PER_HOUR` with the integer value `3600`.

## Explanation
- 1 hour = 60 minutes
- 1 minute = 60 seconds  
- Therefore: 1 hour = 60 × 60 = 3600 seconds

## Available DateTimeInterface Constants
The following constants are actually available in `DateTimeInterface`:

- `ATOM` - Y-m-d\TH:i:sP
- `COOKIE` - l, d-M-Y H:i:s T
- `ISO8601` - Y-m-d\TH:i:sO
- `ISO8601_EXPANDED` - X-m-d\TH:i:sP
- `RFC822` - D, d M y H:i:s O
- `RFC850` - l, d-M-y H:i:s T
- `RFC1036` - D, d M y H:i:s O
- `RFC1123` - D, d M Y H:i:s O
- `RFC7231` - D, d M Y H:i:s \G\M\T
- `RFC2822` - D, d M Y H:i:s O
- `RFC3339` - Y-m-d\TH:i:sP
- `RFC3339_EXTENDED` - Y-m-d\TH:i:s.vP
- `RSS` - D, d M Y H:i:s O
- `W3C` - Y-m-d\TH:i:sP

## Alternative Solutions
If you need time-related constants, consider using:

1. Direct calculation: `60 * 60` (for clarity)
2. Carbon library constants if available
3. Define your own constants:
   ```php
   const SECONDS_PER_HOUR = 3600;
   const SECONDS_PER_MINUTE = 60;
   const MINUTES_PER_HOUR = 60;
   ```

## Example Fix
```php
// Before (WRONG - will cause error):
$cacheTime = DateTimeInterface::SECONDS_PER_HOUR * 2;

// After (CORRECT):
$cacheTime = 3600 * 2; // 2 hours in seconds
```