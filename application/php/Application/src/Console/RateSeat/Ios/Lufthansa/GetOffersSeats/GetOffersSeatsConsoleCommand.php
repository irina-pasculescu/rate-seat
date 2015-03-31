<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/11/14
 * Time: 4:14 PM
 */


namespace Application\Console\RateSeat\Ios\Lufthansa\GetOffersSeats;


use Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\OffersSeatMaps\Load\OffersSeatMapsLoadRequestHandler;
use Application\Api\RateSeat\V1\Ios\Server\RpcContext;
use Application\Console\Base\BaseConsoleCommand;
use Application\Utils\ClassUtil;
use Application\Utils\ExceptionUtil;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class GameSessionLoadConsoleCommand
 * @package Application\Console\RateSeatApi\Game\Player\GameSession\Load
 */
class GetOffersSeatsConsoleCommand extends BaseConsoleCommand
{

    /*

    Example:

    ./console/rate-seat/run.php rate-seat:ios:lufthansa:get-flight-status --apiToken="fk9qgddrt9uf4k7ug6w97xym"


    */

    const COMMAND_NAME = 'rate-seat:ios:lufthansa:get-offers-seats';

    const API_TOKEN     = 'apiToken';
    const FLIGHT_NUMBER = 'flightNumber';
    const DATE          = 'date';
    const ORIGIN        = 'origin';
    const DESTINATION   = 'destination';
    const CABIN_CLASS   = 'cabinClass';

    /**
     *
     */
    protected function configure()
    {
        $this->setName( $this::COMMAND_NAME )
             ->setDescription(
                 ''
                 . ClassUtil::getClassNameAsJavaStyle( $this )
             )

             ->addOption(
                 $this::API_TOKEN, null, InputOption::VALUE_REQUIRED
             )
             ->addOption(
                 $this::FLIGHT_NUMBER, null, InputOption::VALUE_REQUIRED
             )
             ->addOption(
                 $this::ORIGIN, null, InputOption::VALUE_REQUIRED
             )
             ->addOption(
                 $this::DESTINATION, null, InputOption::VALUE_REQUIRED
             )
             ->addOption(
                 $this::CABIN_CLASS, null, InputOption::VALUE_REQUIRED
             )

             ->addOption(
                 $this::DATE, null, InputOption::VALUE_REQUIRED
             );

    }

    /**
     * @return int
     * @throws \Exception
     */

    protected function executeCommand()
    {
        $result = 0;

        try {


            $optionName  = $this::API_TOKEN;
            $optionValue = $this->getInput()->getOption( $optionName );
            $apiToken    = $optionValue;
            if ( empty( $optionValue ) ) {

                throw new \InvalidArgumentException(
                    'Invalid value for option: ' . $optionName . ' !'
                    . ' Must be  ' . $optionName . ' - not empty!'
                );
            }

            $optionName   = $this::FLIGHT_NUMBER;
            $optionValue  = $this->getInput()->getOption( $optionName );
            $flightNumber = $optionValue;
            if ( empty( $optionValue ) ) {

                throw new \InvalidArgumentException(
                    'Invalid value for option: ' . $optionName . ' !'
                    . ' Must be  ' . $optionName . ' - not empty!'
                );
            }

            $optionName  = $this::DATE;
            $optionValue = $this->getInput()->getOption( $optionName );
            $date        = $optionValue;
            if ( empty( $optionValue ) ) {

                throw new \InvalidArgumentException(
                    'Invalid value for option: ' . $optionName . ' !'
                    . ' Must be  ' . $optionName . ' - not empty!'
                );
            }

            $optionName  = $this::DESTINATION;
            $optionValue = $this->getInput()->getOption( $optionName );
            $destination = $optionValue;
            if ( empty( $optionValue ) ) {

                throw new \InvalidArgumentException(
                    'Invalid value for option: ' . $optionName . ' !'
                    . ' Must be  ' . $optionName . ' - not empty!'
                );
            }

            $optionName  = $this::ORIGIN;
            $optionValue = $this->getInput()->getOption( $optionName );
            $origin      = $optionValue;
            if ( empty( $optionValue ) ) {

                throw new \InvalidArgumentException(
                    'Invalid value for option: ' . $optionName . ' !'
                    . ' Must be  ' . $optionName . ' - not empty!'
                );
            }

            $optionName  = $this::CABIN_CLASS;
            $optionValue = $this->getInput()->getOption( $optionName );
            $cabinClass  = $optionValue;
            if ( empty( $optionValue ) ) {

                throw new \InvalidArgumentException(
                    'Invalid value for option: ' . $optionName . ' !'
                    . ' Must be ' . $optionName . ' - not empty!'
                );
            }

            $request = array(
                'apiToken'     => $apiToken,
                'flightNumber' => $flightNumber,
                'date'         => $date,
                'origin'       => $origin,
                'destination'  => $destination,
                'cabinClass'   => $cabinClass,
            );

            $this->echoLn( 'API REQUEST ...', 2 );

            $this->echoLn( json_encode( $request ), 2 );

            $rpcContext     = new RpcContext();
            $requestHandler = new OffersSeatMapsLoadRequestHandler(
                $rpcContext
            );

            $startTs        = microtime( true );
            $responseResult = $requestHandler->handleRequest( $request );
            $stopTs         = microtime( true );
            $response       = array(
                'result'   => $responseResult,
                'duration' => $stopTs - $startTs,
            );


            $this->echoLn( 'API RESPONSE ...', 2 );
            $this->echoLn( json_encode( $response ), 2 );

            $this->echoLn( 'done.', 2 );


        }
        catch (\Exception $e) {

            $this->echoLn( 'EXCEPTION !', 2 );

            $this->echoLn( json_encode( ExceptionUtil::exceptionAsArray( $e, true ) ), 2 );

            throw $e;


        }


        return $result;
    }


}