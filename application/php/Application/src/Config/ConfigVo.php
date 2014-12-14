<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 10/8/13
 * Time: 2:28 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Config;


use Application\BaseVo;

/**
 * Class ConfigVo
 *
 * @package Application\Config
 */
class ConfigVo extends BaseVo
{
    const KEY_BOOTSTRAP = 'bootstrap';
    const KEY_HOSTNAME  = 'hostname';
    const KEY_COUCHBASE = 'couchbase';


    /**
     * @return $this
     * @throws ConfigException
     */
    public function requireHasData()
    {
        if ( $this->hasData() ) {

            return $this;
        }

        throw new ConfigException( 'Failed to load config !' );
    }


    /**
     * @param string $prefix
     *
     * @return $this
     * @throws ConfigException
     */
    public function validate( $prefix = '' )
    {
        $key     = $this::KEY_HOSTNAME;
        $value   = $this->getHostname();
        $isValid = !empty( $value );
        if ( !$isValid ) {

            throw new ConfigException( 'Invalid ' . $prefix . $key . ' !' );
        }

        $this->getCouchbaseVo()->validate();

        return $this;
    }



    // ========= bootstrap ========

    /**
     * @return array
     */
    public function getBootstrap()
    {
        $key   = $this::KEY_BOOTSTRAP;
        $value = $this->getDataKey( $key );
        if ( is_array( $value ) ) {

            return (array)$value;
        }

        return array();
    }

    /**
     * @return BootstrapConfigVo
     */
    public function getBootstrapVo()
    {
        $vo   = new BootstrapConfigVo();
        $data = $this->getBootstrap();
        if ( is_array( $data ) ) {
            $vo->setData( $data );
        }

        return $vo;
    }

    /**
     * @param BootstrapConfigVo $vo
     *
     * @return $this
     */
    public function setBootstrapVo( BootstrapConfigVo $vo )
    {
        $this->setDataKey( $this::KEY_BOOTSTRAP, $vo->getData() );

        return $this;
    }


    // ============= http =============

    /**
     * @return string
     */
    public function getHostname()
    {
        return (string)$this->getDataKey( $this::KEY_HOSTNAME );
    }


    // =========== couchbase ====================
    /**
     * @return array
     */
    public function getCouchbase()
    {
        $key   = $this::KEY_COUCHBASE;
        $value = $this->getDataKey( $key );
        if ( is_array( $value ) ) {

            return (array)$value;
        }

        return array();
    }

    /**
     * @return CouchbaseConfigVo
     */
    public function getCouchbaseVo()
    {
        $vo   = new CouchbaseConfigVo();
        $data = $this->getCouchbase();
        if ( is_array( $data ) ) {
            $vo->setData( $data );
        }

        return $vo;
    }


}