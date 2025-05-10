<?php

namespace AndreasGlaser\Helpers\Traits;

/**
 * RuntimeCacheTrait provides in-memory caching functionality during script execution.
 * 
 * This trait adds methods for:
 * - Storing and retrieving cached data
 * - Managing cache groups
 * - Generating unique cache IDs
 * - Handling cache expiration and overwrites
 */
trait RuntimeCacheTrait
{
    /**
     * @var array Stores cached data organized by groups and IDs
     */
    protected $runtimeCache = [];

    /**
     * Sets a value in the runtime cache.
     *
     * @param mixed $data The data to cache
     * @param string $id The cache key
     * @param string $group The cache group (default: '_default')
     * @param bool $overwrite Whether to overwrite existing data
     *
     * @return $this For method chaining
     */
    public function rtcSet($data, string $id, string $group = '_default', bool $overwrite = true): self
    {
        if (!$overwrite && $this->rtcExists($id, $group)) {
            return $this;
        }

        $this->rtcGroupAdd($group);
        $this->runtimeCache[$group][$id] = $data;

        return $this;
    }

    /**
     * Checks if a value exists in the runtime cache.
     *
     * @param string $id The cache key to check
     * @param string $group The cache group (default: '_default')
     *
     * @return bool True if the value exists, false otherwise
     */
    public function rtcExists(string $id, string $group = '_default'): bool
    {
        if (!$this->rtcGroupExists($group)) {
            return false;
        }

        return \array_key_exists($id, $this->runtimeCache[$group]);
    }

    /**
     * Retrieves a value from the runtime cache.
     *
     * @param string $id The cache key
     * @param string $group The cache group (default: '_default')
     * @param mixed $default The default value to return if the key doesn't exist
     *
     * @return mixed The cached value or the default value
     */
    public function rtcGet(string $id, string $group = '_default', $default = null)
    {
        if (!$this->rtcExists($id, $group)) {
            return $default;
        }

        return $this->runtimeCache[$group][$id];
    }

    /**
     * Retrieves and removes a value from the runtime cache.
     *
     * @param string $id The cache key
     * @param string $group The cache group (default: '_default')
     * @param mixed $default The default value to return if the key doesn't exist
     *
     * @return mixed The cached value or the default value
     */
    public function rtcGetDelete(string $id, string $group = '_default', $default = null)
    {
        $result = $this->rtcGet($id, $group, $default);
        $this->rtcDelete($id, $group);

        return $result;
    }

    /**
     * Removes a value from the runtime cache.
     *
     * @param string $id The cache key to remove
     * @param string $group The cache group (default: '_default')
     *
     * @return $this For method chaining
     */
    public function rtcDelete(string $id, string $group = '_default'): self
    {
        if ($this->rtcExists($id, $group)) {
            unset($this->runtimeCache[$group][$id]);
        }

        return $this;
    }

    /**
     * Retrieves all values from a cache group.
     *
     * @param string $group The cache group
     * @param mixed $default The default value to return if the group doesn't exist
     *
     * @return mixed The group's cached values or the default value
     */
    public function rtcGroupGet(string $group, $default = null)
    {
        return $this->rtcGroupExists($group) ? $this->runtimeCache[$group] : $default;
    }

    /**
     * Removes an entire cache group.
     *
     * @param string $group The cache group to remove
     *
     * @return $this For method chaining
     */
    public function rtcGroupDelete(string $group): self
    {
        if (!$this->rtcGroupExists($group)) {
            return $this;
        }

        unset($this->runtimeCache[$group]);

        return $this;
    }

    /**
     * Creates a new cache group.
     *
     * @param string $group The cache group to create
     *
     * @return $this For method chaining
     */
    public function rtcGroupAdd(string $group): self
    {
        if (!$this->rtcGroupExists($group)) {
            $this->runtimeCache[$group] = [];
        }

        return $this;
    }

    /**
     * Checks if a cache group exists.
     *
     * @param string $group The cache group to check
     *
     * @return bool True if the group exists, false otherwise
     */
    public function rtcGroupExists(string $group): bool
    {
        return \array_key_exists($group, $this->runtimeCache);
    }

    /**
     * Generates a unique cache ID based on the provided arguments.
     * 
     * This method:
     * - Serializes the provided arguments
     * - Creates an MD5 hash of the serialized data
     * - Ensures unique IDs for different argument combinations
     *
     * @return string A unique cache ID
     */
    public function rtcMakeId(): string
    {
        return \md5(\serialize(\func_get_args()));
    }
}
