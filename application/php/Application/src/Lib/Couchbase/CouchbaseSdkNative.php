<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 3:13 PM
 */

namespace Application\Lib\Couchbase;

/**
 * Class CouchbaseSdkNative
 *
 * @package Application\Lib\Couchbase
 */
class CouchbaseSdkNative extends \Couchbase
{


    /**
     * @var CouchbaseClientConfigVo
     */
    protected $configVo;

    /**
     * @return CouchbaseClientConfigVo
     */
    protected function getConfigVo()
    {
        return $this->configVo;
    }

    /**
     * @param CouchbaseClientConfigVo $configVo
     */
    public function __construct(CouchbaseClientConfigVo $configVo)
    {
        $this->configVo = $configVo;

        $configVo->validate();

        parent::__construct(
            array(
                $configVo->getHost()
            ),
            $configVo->getUser(),
            $configVo->getPassword(),
            $configVo->getBucket(),
            $configVo->getPersistent()
        );
    }

} 