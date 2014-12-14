<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 1:43 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Console\Base;

use Application\Bootstrap;
use Application\Console\Base\BaseConsoleApplication as ConsoleApplication;

/**
 * Class BaseConsoleDispatcher
 *
 * @package Application\Console\Base
 */
abstract class BaseConsoleDispatcher
{


    /**
     * @var ConsoleApplication
     */
    private $consoleApplication;

    /**
     * @return ConsoleApplication
     */
    public function getConsoleApplication()
    {
        if ( !$this->consoleApplication ) {
            $this->consoleApplication = new ConsoleApplication();
        }

        return $this->consoleApplication;
    }

    /**
     * @return $this
     */
    public function run()
    {
        $this->init();
        $this->execute();
    }

    /**
     * @return $this
     */
    protected function init()
    {
        $bootstrap = Bootstrap::getInstance();
        $bootstrap->init( $bootstrap::MODE_CONSOLE );

        return $this;
    }

    /**
     * @return $this
     */
    abstract protected function execute();


}