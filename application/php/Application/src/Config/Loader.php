<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/23/13
 * Time: 5:53 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Config;


/**
 * Class Loader
 *
 * @package Application\Config
 */
class Loader
{
    /**
     * @var ConfigVo
     */
    protected $configVo;

    /**
     * @var \SplFileInfo
     */
    protected $configFile;


    /**
     * @param ConfigVo $configVo
     * @param \SplFileInfo $configFile
     */
    public function __construct(ConfigVo $configVo, \SplFileInfo $configFile)
    {
        $this->configVo = $configVo;
        $this->configFile = $configFile;
    }

    /**
     * @return \SplFileInfo
     */
    public function getConfigFile()
    {
        return $this->configFile;
    }

    /**
     * @return ConfigVo
     */
    public function getConfigVo()
    {
        return $this->configVo;
    }

    /**
     * @return ConfigVo
     * @throws ConfigException
     */
    public function load()
    {
        $vo = $this->getConfigVo();
        try {
            $configFile = $this->getConfigFile();
            $location = $configFile->getPathname();
            $isValid = is_string($location) && (!empty($location));
            if (!$isValid) {

                throw new \Exception('Config file does not exist!');
            }

            $text = file_get_contents($configFile->getPathname());
            $isValid = ((is_string($text)) && (!empty($text)));
            if (!$isValid) {
                throw new \Exception('Config file content is empty!');
            }
            $configData = json_decode($text, true);
            if (!is_array($configData)) {

                throw new \Exception('Config data (decoded) must be an array!');
            }

            $vo->setData($configData);

        } catch (\Exception $e) {
            // nop
            throw new ConfigException(
                'Failed to load config! details=' . $e->getMessage()
            );
        }

        return $vo;
    }

}