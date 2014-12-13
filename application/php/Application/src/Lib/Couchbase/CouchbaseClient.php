<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 2:47 PM
 */
namespace Application\Lib\Couchbase;


/**
 * Class CouchbaseClient
 *
 * @package Application\Lib\Couchbase
 */
class CouchbaseClient
{

    /**
     * @param $data
     *
     * @return CouchbaseClientConfigVo
     */
    public static function createClientConfigVo($data)
    {
        $vo = new CouchbaseClientConfigVo();
        $vo->setData($data);

        return $vo;
    }

    /**
     * @var CouchbaseClientConfigVo
     */
    protected $configVo;

    /**
     * @return CouchbaseClientConfigVo
     */
    public function getConfigVo()
    {
        return $this->configVo;
    }

    /**
     * @param CouchbaseClientConfigVo $configVo
     */
    public function __construct(CouchbaseClientConfigVo $configVo)
    {
        $this->configVo = $configVo;
    }

    /**
     * @var CouchbaseSdkNative
     */
    protected $sdkNative;

    /**
     * @return CouchbaseSdkNative
     */
    public function getSdkNative()
    {
        if (!$this->sdkNative) {
            $this->sdkNative = new CouchbaseSdkNative(
                $this->getConfigVo()
            );
        }

        return $this->sdkNative;
    }

    /**
     * @var CouchbaseSdkJson
     */
    protected $sdkJson;

    /**
     * @return CouchbaseSdkJson
     */
    public function getSdkJson()
    {
        if (!$this->sdkJson) {
            $this->sdkJson = new CouchbaseSdkJson(
                $this->getSdkNative()
            );
        }

        return $this->sdkJson;
    }

} 