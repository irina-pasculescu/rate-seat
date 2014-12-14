<?php

namespace Application;

/**
 * Class BaseVo
 *
 * @package Application
 */
class BaseVo implements BaseVoInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData( $data )
    {
        $result = $this;

        if ( $data instanceof \stdClass ) {
            $dataAsArray = array();
            foreach ( $data as $key => $value ) {
                $dataAsArray[ $key ] = $value;
            }
            $data = $dataAsArray;
        }

        if ( !is_array( $data ) ) {
            $data = array();
        }
        $this->data = $data;

        return $result;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if ( !is_array( $this->data ) ) {
            $this->data = array();
        }

        return $this->data;
    }

    /**
     * @return $this
     */
    public function unsetData()
    {
        $result = $this;

        $this->data = array();

        return $result;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getDataKey( $key )
    {
        $result = null;

        $data = $this->getData();
        if ( !array_key_exists( $key, $data ) ) {

            return $result;
        }

        return $data[ $key ];
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setDataKey( $key, $value )
    {
        $result = $this;

        $data         = $this->getData();
        $data[ $key ] = $value;
        $this->data   = $data;

        return $result;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasDataKey( $key )
    {
        $data = $this->getData();

        return array_key_exists( $key, $data );
    }

    /**
     * @return bool
     */
    public function hasData()
    {
        $data = $this->getData();

        return is_array( $data ) && ( count( $data ) > 0 );
    }
} 