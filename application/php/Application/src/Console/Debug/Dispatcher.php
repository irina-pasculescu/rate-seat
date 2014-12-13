<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 1:43 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Console\Debug;

use Application\Console\Base\BaseConsoleDispatcher;
use Application\Console\Debug\Command\GetApplicationSettingsMvo;
use Application\Console\Debug\Command\GetConfig;
use Application\Console\Debug\Command\TestExampleMvo;

/**
 * Class Dispatcher
 *
 * @package Application\Console\Debug
 */
class Dispatcher extends BaseConsoleDispatcher
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * @return $this
     */
    protected function execute()
    {
        $consoleApplication = $this->getConsoleApplication();
        $consoleApplication->add(new GetConfig());
        $consoleApplication->add(new TestExampleMvo());
        $consoleApplication->add(new GetApplicationSettingsMvo());

        $consoleApplication->run();

        return $this;
    }


}