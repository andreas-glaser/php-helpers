<?php

namespace AndreasGlaser\Helpers\Traits;

/**
 * Class RuntimeCacheTrait
 *
 * @package AndreasGlaser\Helpers\Traits
 * @author  Andreas Glaser
 */
trait RuntimeCacheTrait
{
    /**
     * @var array
     */
    static $runtimeCache = [];

    /**
     * @param        $data
     * @param        $id
     * @param string $group
     * @param bool   $overwrite
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function rtcSet($data, $id, $group = '_default', $overwrite = true)
    {
        if (!$overwrite && $this->rtcExists($id, $group)) {
            return $this;
        }

        $this->rtcGroupAdd($group);
        static::$runtimeCache[$group][$id] = $data;

        return $this;
    }

    /**
     * @param        $id
     * @param string $group
     *
     * @return bool
     * @author Andreas Glaser
     */
    public function rtcExists($id, $group = '_default')
    {
        if (!$this->rtcGroupExists($group)) {
            return false;
        }

        return array_key_exists($id, static::$runtimeCache[$group]);
    }

    /**
     * @param        $id
     * @param string $group
     * @param null   $default
     *
     * @return null
     * @author Andreas Glaser
     */
    public function rtcGet($id, $group = '_default', $default = null)
    {
        if (!$this->rtcExists($id, $group)) {
            return $default;
        }

        return static::$runtimeCache[$group][$id];
    }

    /**
     * @param        $id
     * @param string $group
     * @param null   $default
     *
     * @return null
     * @author Andreas Glaser
     */
    public function rtcGetDelete($id, $group = '_default', $default = null)
    {
        $result = $this->rtcGet($id, $group, $default);
        $this->rtcDelete($id, $group);

        return $result;
    }

    /**
     * @param        $id
     * @param string $group
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function rtcDelete($id, $group = '_default')
    {
        if ($this->rtcExists($id, $group)) {
            unset(static::$runtimeCache[$group][$id]);
        }

        return $this;
    }

    /**
     * @param      $group
     * @param null $default
     *
     * @return null
     * @author Andreas Glaser
     */
    public function rtcGroupGet($group, $default = null)
    {
        return $this->rtcGroupExists($group) ? static::$runtimeCache[$group] : $default;
    }

    /**
     * @param $group
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function rtcGroupDelete($group)
    {
        if (!$this->rtcGroupExists($group)) {
            return $this;
        }

        unset(static::$runtimeCache[$group]);

        return $this;
    }

    /**
     * @param $group
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function rtcGroupAdd($group)
    {
        if (!$this->rtcGroupExists($group)) {
            static::$runtimeCache[$group] = [];
        }

        return $this;
    }

    /**
     * @param $group
     *
     * @return bool
     * @author Andreas Glaser
     */
    public function rtcGroupExists($group)
    {
        return array_key_exists($group, static::$runtimeCache);
    }

    /**
     * @return string
     * @author Andreas Glaser
     */
    public function rtcMakeId()
    {
        return md5(serialize(func_get_args()));
    }
}