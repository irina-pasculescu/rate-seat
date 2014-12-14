<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 10:48 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application;


use Application\Lib\Couchbase\CouchbaseClient;
use Application\Utils\ClassUtil;

/**
 * Class Context
 *
 * @package Application
 */
class Context
{
    // must match with ApplicationSettings
    const PROJECT_NAME = Bootstrap::PROJECT_NAME;


    /**
     * @return float
     */
    public function getStartMicroTime()
    {
        return (float)$this->getBootstrap()->getStartMicroTime();
    }


    /**
     * @return int
     */
    public function getStartTime()
    {

        return (int)floor( $this->getStartMicroTime() );
    }

    /**
     * @return Bootstrap
     */
    public function getBootstrap()
    {
        return Bootstrap::getInstance();
    }


    // =========== singleton ========
    /**
     * @var self
     */
    private static $instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if ( !self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    // ============= model ================
    /**
     * @var Model
     */
    private $model;

    /**
     * @return Model
     */
    public function getModel()
    {
        if ( !$this->model ) {
            $this->model = new Model();
        }

        return $this->model;
    }


    // =============== prepare & apply config ==========================

    /**
     * @return $this
     */
    public function prepare()
    {
        $this->applyConfig();

        return $this;
    }


    /**
     * @return $this
     * @throws \Exception
     */
    private function applyConfig()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );
        $model  = $this->getModel();

        $model->setIsConfigAppliedToApplication( true );

        $configVo = $model->getConfigVo();
        try {
            $configVo->validate();
        }
        catch (\Exception $e) {

            throw $e;
        }


        return $this;
    }


    /**
     * @return Profiler
     */
    public function getProfiler()
    {
        return $this->getBootstrap()->getProfiler();
    }


    // ========== couchbase ============

    /**
     * @var CouchbaseClient
     */
    protected $couchbaseClient;

    /**
     * @return CouchbaseClient
     */
    public function getCouchbaseClient()
    {
        if ( !$this->couchbaseClient ) {

            $this->couchbaseClient = new CouchbaseClient(
                CouchbaseClient::createClientConfigVo(
                    $this->getModel()
                         ->getConfigVo()
                         ->getCouchbaseVo()
                         ->getData()
                )
            );
        }

        return $this->couchbaseClient;
    }


}