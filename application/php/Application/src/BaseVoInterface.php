<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/23/14
 * Time: 9:01 AM
 */

namespace Application;

/**
 * Interface BaseVoInterface
 *
 * @package Application
 */
interface BaseVoInterface
{

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData( $data );

    /**
     * @return array
     */
    public function getData();

    /**
     * @return $this
     */
    public function unsetData();

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getDataKey( $key );

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setDataKey( $key, $value );

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasDataKey( $key );

    /**
     * @return bool
     */
    public function hasData();
} 