<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * Get the current cache version for a given key.
     *
     * @param string $prefix
     * @return int
     */
    private static function getCacheVersion(string $prefix): int
    {
        return Cache::get("cache_version_{$prefix}", 1);
    }

    /**
     * Generate cache key with version.
     *
     * @param string $prefix
     * @return string
     */
    private static function getVersionedKey(string $prefix): string
    {
        $version = self::getCacheVersion($prefix);
        return "{$prefix}_v{$version}";
    }

    /**
     * Store data in cache with versioning.
     *
     * @param string $prefix
     * @param mixed $data
     * @param int $minutes
     */
    public static function put(string $prefix, $data, int $minutes = 10)
    {
        $key = self::getVersionedKey($prefix);
        Cache::put($key, $data, now()->addMinutes($minutes));
    }

    /**
     * Retrieve data from cache using versioning.
     *
     * @param string $prefix
     * @return mixed
     */
    public static function get(string $prefix)
    {
        $key = self::getVersionedKey($prefix);
        return Cache::get($key);
    }

    /**
     * Clear cache by increasing version number.
     *
     * @param string $prefix
     */
    public static function clear(string $prefix)
    {
        Cache::increment("cache_version_{$prefix}");
    }
}
