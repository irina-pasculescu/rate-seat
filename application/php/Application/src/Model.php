<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/23/13
 * Time: 5:36 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application;


use Application\Config\ConfigVo;
use Application\Mvo\ApplicationSettings\ApplicationSettingsMvo;
use Application\Utils\ClassUtil;
use Application\Utils\ExceptionUtil;

/**
 * Class Model
 *
 * @package Application
 */
class Model
{

    /**
     * @var ConfigVo
     */
    private $configVo;
    /**
     * @var bool
     */
    private $isConfigLoaded = false;
    /**
     * @var bool
     */
    private $isConfigAppliedToApplication = false;


    /**
     * @return Context
     */
    public function getApplicationContext()
    {
        return Context::getInstance();
    }


    // ================= config ==================
    /**
     * @return ConfigVo
     * @throws \Exception
     */
    public function getConfigVo()
    {
        if (!$this->isConfigLoaded) {

            throw new \Exception(
                'Config has not been loaded yet! ' . __METHOD__
            );
        }

        return $this->configVo;
    }

    /**
     * @param ConfigVo $configVo
     *
     * @return $this
     */
    public function setConfigVo(ConfigVo $configVo)
    {
        $this->configVo = $configVo;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsConfigLoaded()
    {
        return ($this->isConfigLoaded === true);
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setIsConfigLoaded($value)
    {
        $this->isConfigLoaded = $value;

        return $this;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setIsConfigAppliedToApplication($value)
    {
        $this->isConfigAppliedToApplication = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsConfigAppliedToApplication()
    {
        return ($this->isConfigAppliedToApplication === true);
    }

    // ============= http ======================


    /**
     * @return string
     */
    public function getHttpHostDefault()
    {
        $configVo = $this->getConfigVo();

        return $configVo->getHostname();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getHttpHost()
    {
        $host = null;
        if (isset($_SERVER) && isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        }

        $isValid = is_string($host) && (!empty($host));
        if ($isValid) {

            return (string)$host;
        }

        $host = $this->getHttpHostDefault();
        $isValid = is_string($host) && (!empty($host));
        if ($isValid) {

            return (string)$host;
        }

        throw new \Exception(
            'No http host found! '
            . ClassUtil::getQualifiedMethodName($this, __METHOD__, true)
        );
    }


    // ============== application settings =============
    /**
     * @var ApplicationSettingsMvo
     */
    private $applicationSettingsMvo;

    /**
     * @return ApplicationSettingsMvo
     * @throws \Exception
     */
    public function getApplicationSettingsMvo()
    {

        if (!$this->applicationSettingsMvo) {

            try {
                $mvo = new ApplicationSettingsMvo();
                $this->applicationSettingsMvo = $mvo;
                $mvo->load();
                $mvo->requireIsLoaded(
                    'memId=' . $mvo->getMvoMemId() . ' !'
                );

            } catch (\Exception $e) {

                // delegate exception

                throw $e;
            }

        }

        return $this->applicationSettingsMvo;
    }


    // ==============================================


}