<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 2:50 PM
 */
namespace Application\Lib\Couchbase;

use Application\BaseVo;
use Application\Utils\ClassUtil;

/**
 * Class CouchbaseClientConfigVo
 *
 * @package Application\Lib\Couchbase
 */
class CouchbaseClientConfigVo extends BaseVo
{


    const KEY_HOST       = 'host';
    const KEY_USER       = 'user';
    const KEY_PASSWORD   = 'password';
    const KEY_BUCKET     = 'bucket';
    const KEY_PERSISTENT = 'persistent';

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
     * @return bool
     */
    public function getPersistent()
    {
        return true;
    }


    /**
     * @return $this
     * @throws CouchbaseClientConfigException
     */
    public function validate()
    {

        $key     = $this::KEY_HOST;
        $value   = $this->getHost();
        $isValid = !empty( $value );
        if ( !$isValid ) {

            throw new CouchbaseClientConfigException(
                'Invalid ' .
                ClassUtil::getQualifiedMethodName( $this, $key, true )
                . ' !'
            );
        }

        $key   = $this::KEY_USER;
        $value = $this->getUser();


        $key   = $this::KEY_PASSWORD;
        $value = $this->getPassword();


        $key     = $this::KEY_BUCKET;
        $value   = $this->getBucket();
        $isValid = !empty( $value );
        if ( !$isValid ) {

            throw new CouchbaseClientConfigException(
                'Invalid ' .
                ClassUtil::getQualifiedMethodName( $this, $key, true )
                . ' !'
            );
        }

        $key     = $this::KEY_PERSISTENT;
        $value   = $this->getPersistent();
        $isValid = is_bool( $value );
        if ( !$isValid ) {

            throw new CouchbaseClientConfigException(
                'Invalid ' .
                ClassUtil::getQualifiedMethodName( $this, $key, true )
                . ' !'
            );
        }

        return $this;
    }


}