<?php

namespace AndreasGlaser\Helpers\Traits;

/**
 * Trait RuntimeCacheTrait
 *
 * @package AndreasGlaser\Helpers\Traits
 */
trait RuntimeCacheTrait
{
    /**
     * @var array
     */
    protected $runtimeCache = [];

    /**
     * @param        $data
     * @param string $id
     * @param string $group
     * @param bool   $overwrite
     *
     * @return self
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
     * @param string $id
     * @param string $group
     *
     * @return bool
     */
    public function rtcExists(string $id, string $group = '_default'): bool
    {
        if (!$this->rtcGroupExists($group)) {
            return false;
        }

        return array_key_exists($id, $this->runtimeCache[$group]);
    }

    /**
     * @param string $id
     * @param string $group
     * @param null   $default
     *
     * @return mixed
     */
    public function rtcGet(string $id, string $group = '_default', $default = null)
    {
        if (!$this->rtcExists($id, $group)) {
            return $default;
        }

        return $this->runtimeCache[$group][$id];
    }

    /**
     * @param string $id
     * @param string $group
     * @param mixed  $default
     *
     * @return mixed
     */
    public function rtcGetDelete(string $id, string $group = '_default', $default = null)
    {
        $result = $this->rtcGet($id, $group, $default);
        $this->rtcDelete($id, $group);

        return $result;
    }

    /**
     * @param string $id
     * @param string $group
     *
     * @return self
     */
    public function rtcDelete(string $id, string $group = '_default'): self
    {
        if ($this->rtcExists($id, $group)) {
            unset($this->runtimeCache[$group][$id]);
        }

        return $this;
    }

    /**
     * @param string $group
     * @param null   $default
     *
     * @return mixed
     */
    public function rtcGroupGet(string $group, $default = null)
    {
        return $this->rtcGroupExists($group) ? $this->runtimeCache[$group] : $default;
    }

    /**
     * @param string $group
     *
     * @return self
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
     * @param string $group
     *
     * @return self
     */
    public function rtcGroupAdd(string $group): self
    {
        if (!$this->rtcGroupExists($group)) {
            $this->runtimeCache[$group] = [];
        }

        return $this;
    }

    /**
     * @param string $group
     *
     * @return bool
     */
    public function rtcGroupExists(string $group): bool
    {
        return array_key_exists($group, $this->runtimeCache);
    }

    /**
     * @return string
     */
    public function rtcMakeId(): string
    {
        return md5(serialize(func_get_args()));
    }
}