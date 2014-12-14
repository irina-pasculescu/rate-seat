<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/11/14
 * Time: 4:13 PM
 */

namespace Application\Console\RateSeat;


use Application\Console\Base\BaseConsoleDispatcher;
use
    Application\Console\RateSeat\Ios\Lufthansa\GetFlightStatus\GetFlightStatusConsoleCommand;
use Application\Console\RateSeat\Ios\Lufthansa\GetOffersSeats\GetOffersSeatsConsoleCommand;

/**
 * Class Dispatcher
 * @package Application\Console\RateSeat
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
        if ( !self::$instance ) {
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
        $consoleApplication->add( new GetFlightStatusConsoleCommand() );
        $consoleApplication->add( new GetOffersSeatsConsoleCommand() );
        $consoleApplication->run();

        return $this;
    }


}