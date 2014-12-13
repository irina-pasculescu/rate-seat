<?php

namespace Application;

use Application\Config\ConfigVo;
use Application\Config\Loader as ConfigLoader;
use Application\Utils\ClassUtil;
use Application\Utils\ExceptionUtil;

/**
 * Class BaseBootstrap
 *
 * @package Application
 */
abstract class BaseBootstrap
{

    const PROJECT_NAME = 'base-project';

    const MODE_UNKNOWN = 'MODE_UNKNOWN';
    const MODE_HTTP    = 'MODE_HTTP';
    const MODE_CONSOLE = 'MODE_CONSOLE';


    /**
     * @var float
     */
    protected $startMicroTime = 0.0;

    /**
     * @return float
     */
    public function getStartMicroTime()
    {
        return (float)$this->startMicroTime;
    }


    /**
     * @var Profiler
     */
    protected $profiler;

    /**
     * @return Profiler
     */
    public function getProfiler()
    {
        if ( !$this->profiler ) {
            $this->profiler = new Profiler();
        }

        return $this->profiler;
    }

    /**
     * @var string
     */
    protected $mode = self::MODE_UNKNOWN;

    /**
     * @return string
     */
    public function getMode()
    {
        return (string)$this->mode;
    }


    /**
     * @return Context
     */
    public function getContext()
    {
        return Context::getInstance();
    }

    /**
     * @return Model
     */
    abstract public function getModel();


    // ================ init =====================

    /**
     * @param $mode
     *
     * @return $this
     * @throws \Exception
     */
    public function init( $mode )
    {
        ini_set( 'display_errors', false );
        ini_set( 'html_errors', false );

        $this->defineProjectPath();
        define( 'PROJECT_PATH', $this->getProjectPath() );

        $this->mode           = $mode;
        $this->startMicroTime = microtime( true );
        $this->getProfiler()->startTrackingByKey( 'application' );

        error_reporting( E_ALL | E_STRICT );

        set_error_handler(
            array(
                $this,
                'errorHandler'
            )
        );
        set_exception_handler(
            array(
                $this,
                'exceptionHandler'
            )
        );

        $this->initLocale();

        // config
        $this->applyConfigDefault();
        $this->defineConfigFileLocation();
        $this->loadConfig();
        $this->applyConfigLoaded();


        if ( $this::PROJECT_NAME === 'base-project' ) {

            throw new \Exception( 'Invalid Bootstrap.PROJECT_NAME !' );
        }

        // context
        $this->prepareApplicationContext();

        return $this;
    }

    /**
     * @return $this
     */
    protected function initLocale()
    {
        setlocale( LC_ALL, 'C' );
        date_default_timezone_set( 'Europe/Berlin' );

        return $this;
    }


    /**
     * @var string
     */
    protected $projectPath = '';

    /**
     * @return string
     */
    public function getProjectPath()
    {
        return (string)$this->projectPath;
    }

    /**
     * @return $this
     */
    protected function defineProjectPath()
    {
        $this->projectPath = __DIR__ . '/../../../..';

        return $this;
    }

    /**
     * @var string
     */
    protected $configFileLocation = '';

    /**
     * @return string
     */
    protected function getConfigFileLocation()
    {
        return (string)$this->configFileLocation;
    }

    /**
     * @return $this
     */
    protected function defineConfigFileLocation()
    {
        $this->configFileLocation = $this->getProjectPath()
                                    . '/config/environment.json';

        return $this;
    }

    // ================== config ==============

    /**
     * @var ConfigVo
     */
    protected $configVo;

    /**
     * @return ConfigVo
     */
    protected function getConfigVo()
    {
        if ( !$this->configVo ) {

            $this->configVo = new ConfigVo();
        }

        return $this->configVo;
    }

    /**
     * @return $this
     */
    protected function applyConfigDefault()
    {
        // custom hooks to be placed here
        return $this;
    }

    /**
     * @return $this
     */
    protected function loadConfig()
    {
        $configFile = new \SplFileInfo( $this->getConfigFileLocation() );
        $vo         = new ConfigVo();
        $loader     = new ConfigLoader(
            $vo,
            $configFile
        );
        $loader->load();
        // use the new (loaded) configVo instead of the default configVo
        $this->configVo = $vo;

        return $this;
    }

    /**
     * @return $this
     */
    protected function applyConfigLoaded()
    {
        // apply to bootstrap
        $configVo = $this->getConfigVo();

        $model = $this->getModel();
        $model->setConfigVo( $configVo );
        $model->setIsConfigLoaded( true );

        // apply config.bootstrap
        $bootstrapConfigVo = $configVo->getBootstrapVo();
        if ( is_bool( $bootstrapConfigVo->getDisplayErrorsEnabled() ) ) {
            ini_set(
                'display_errors',
                $bootstrapConfigVo->getDisplayErrorsEnabled()
            );
        }
        if ( is_bool( $bootstrapConfigVo->getDisplayExceptionsEnabled() ) ) {
            $this->displayExceptionsEnabled
                = $bootstrapConfigVo->getDisplayExceptionsEnabled();
        }
        if ( is_bool( $bootstrapConfigVo->getErrorExceptionsEnabled() ) ) {
            $this->errorExceptionsEnabled
                = $bootstrapConfigVo->getErrorExceptionsEnabled();
        }
        $phpIniSettings = $bootstrapConfigVo->getPhpIni();
        foreach ( $phpIniSettings as $key => $value ) {
            ini_set( $key, $value );
        }

        return $this;
    }



    // =============== Exceptions & Errors ==================

    /**
     * @var \Exception|null
     */
    protected $lastException;

    /**
     * @return \Exception|null
     */
    public function getLastException()
    {
        return $this->lastException;
    }

    /**
     * @var bool
     */
    protected $displayExceptionsEnabled = false;

    /**
     * @return bool
     */
    protected function getDisplayExceptionsEnabled()
    {
        return $this->displayExceptionsEnabled === true;
    }


    /**
     * @var bool
     */
    protected $errorExceptionsEnabled = true;

    /**
     * @return bool
     */
    protected function getErrorExceptionsEnabled()
    {
        return $this->errorExceptionsEnabled === true;
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     *
     * @return bool
     * @throws \ErrorException
     */
    public function errorHandler( $errno, $errstr, $errfile, $errline )
    {
        if ( $this->getErrorExceptionsEnabled() ) {

            throw new \ErrorException( $errstr, 0, $errno, $errfile, $errline );
        }

        // handled
        return true;

    }


    /**
     * @param \Exception $exception
     *
     * @return $this
     */
    public function handleException( \Exception $exception )
    {
        $this->lastException = $exception;

        try {
            $this->sendExceptionResponseHeaders( $exception );
        }
        catch (\Exception $e) {
            // nop
        }

        $this->sendExceptionResponseText( $exception );

        return $this;
    }


    /**
     * @param \Exception $exception
     *
     * @return $this
     */
    protected function sendExceptionResponseHeaders( \Exception $exception )
    {
        switch ($this->getMode()) {
            case self::MODE_HTTP:
                header( 'HTTP/1.1 500 Internal Server Error' );

                break;

            default:

                break;
        }

        return $this;
    }

    /**
     * @param \Exception $exception
     *
     * @return $this
     */
    protected function sendExceptionResponseText( \Exception $exception )
    {
        $message     = 'Whoops! An Error occurred.';
        $messageCode = 'EH';
        try {
            $model = $this->getModel();
            if ( $model->getIsConfigLoaded() ) {
                $messageCode .= 'C';
            }
            if ( $model->getIsConfigAppliedToApplication() ) {
                $messageCode .= 'C';
            }
        }
        catch (\Exception $e) {
            // nop
        }

        $message .= ' (' . $messageCode . ') ';

        echo PHP_EOL . PHP_EOL . $message . PHP_EOL . PHP_EOL;

        if ( $this->getDisplayExceptionsEnabled() ) {
            var_dump( $exception );
            var_dump( $exception->getMessage() );
        }

        return $this;
    }

    /**
     * @param \Exception $exception
     */
    public function exceptionHandler( \Exception $exception )
    {
        $fatalError = null;
        try {
            $this->handleException( $exception );
        }
        catch (\Exception $e) {
            $fatalError = $e;
        }

        if ( $fatalError instanceof \Exception ) {
            throw  \Exception;
        }
    }


    // =============== context ===================

    /**
     * @return $this
     * @throws \Exception
     */
    protected function prepareApplicationContext()
    {
        $methodName = ClassUtil::getQualifiedMethodName(
            $this,
            __METHOD__,
            true
        );
        $profiler   = $this->getProfiler();

        $profiler->startTrackingByKey( $methodName );

        // apply to context
        $context = $this->getContext();

        try {
            $context->prepare();

            $profiler->stopTrackingByKey( $methodName );

            return $this;

        }
        catch (\Exception $e) {
            $profiler->stopTrackingByKey( $methodName );

            var_dump($e->getMessage());die();
        }

    }

    // ===================================================


} 