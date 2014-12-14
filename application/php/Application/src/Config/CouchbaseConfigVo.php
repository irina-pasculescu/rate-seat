<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/16/14
 * Time: 12:15 PM
 */

namespace Application\Config;

use Application\BaseVo;

/**
 * Class CouchbaseConfigVo
 *
 * @package Application\Config
 */
class CouchbaseConfigVo extends BaseVo
{

    const KEY_HOST     = 'host';
    const KEY_USER     = 'user';
    const KEY_PASSWORD = 'password';
    const KEY_BUCKET   = 'bucket';

    /**
     * @return string
     */
    public function getHost()
    {
        return (string)$this->getDataKey( $this::KEY_HOST );
    }


    /**
     * @return string
     */
    public function getUser()
    {
        return (string)$this->getDataKey( $this::KEY_USER );
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return (string)$this->getDataKey( $this::KEY_PASSWORD );
    }

    /**
     * @return string
     */
    public function getBucket()
    {
        return (string)$this->getDataKey( $this::KEY_BUCKET );
    }


    /**
     * @param string $prefix
     *
     * @return $this
     * @throws ConfigException
     */
    public function validate( $prefix = 'couchbase.' )
    {
        $key     = $this::KEY_HOST;
        $value   = $this->getHost();
        $isValid = !empty( $value );
        if ( !$isValid ) {

            throw new ConfigException( 'Invalid ' . $prefix . $key . ' !' );
        }


        $key     = $this::KEY_BUCKET;
        $value   = $this->getBucket();
        $isValid = !empty( $value );
        if ( !$isValid ) {

            throw new ConfigException( 'Invalid ' . $prefix . $key . ' !' );
        }

        return $this;
    }

} 