<?php

namespace AndreasGlaser\Helpers\Traits;

/**
 * Trait RuntimeCacheTrait.
 */
trait RuntimeCacheTrait
{
    /**
     * @var array
     */
    protected $runtimeCache = [];

    /**
     * @param $data
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

    public function rtcExists(string $id, string $group = '_default'): bool
    {
        if (!$this->rtcGroupExists($group)) {
            return false;
        }

        return \array_key_exists($id, $this->runtimeCache[$group]);
    }

    /**
     * @param null $default
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
     * @param mixed $default
     *
     * @return mixed
     */
    public function rtcGetDelete(string $id, string $group = '_default', $default = null)
    {
        $result = $this->rtcGet($id, $group, $default);
        $this->rtcDelete($id, $group);

        return $result;
    }

    public function rtcDelete(string $id, string $group = '_default'): self
    {
        if ($this->rtcExists($id, $group)) {
            unset($this->runtimeCache[$group][$id]);
        }

        return $this;
    }

    /**
     * @param null $default
     *
     * @return mixed
     */
    public function rtcGroupGet(string $group, $default = null)
    {
        return $this->rtcGroupExists($group) ? $this->runtimeCache[$group] : $default;
    }

    public function rtcGroupDelete(string $group): self
    {
        if (!$this->rtcGroupExists($group)) {
            return $this;
        }

        unset($this->runtimeCache[$group]);

        return $this;
    }

    public function rtcGroupAdd(string $group): self
    {
        if (!$this->rtcGroupExists($group)) {
            $this->runtimeCache[$group] = [];
        }

        return $this;
    }

    public function rtcGroupExists(string $group): bool
    {
        return \array_key_exists($group, $this->runtimeCache);
    }

    public function rtcMakeId(): string
    {
        return \md5(\serialize(\func_get_args()));
    }
}
