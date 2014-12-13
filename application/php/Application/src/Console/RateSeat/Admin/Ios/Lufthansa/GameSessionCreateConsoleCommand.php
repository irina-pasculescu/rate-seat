<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/11/14
 * Time: 4:14 PM
 */

namespace Application\Console\RateSeat\Admin\GameSession\Create;




use
    Application\Api\RateSeat\V1\Admin\RequestHandler\GameSession\Create\GameSessionCreateRequestHandler;
use Application\Api\RateSeat\V1\Admin\Server\RpcContext;
use Application\Console\Base\BaseConsoleCommand;
use Application\Definition\RateSeatApi\WhowModel\Game\WhowGameIdType;
use Application\Definition\RateSeatApi\WhowModel\User\WhowUserIdType;
use Application\Utils\ClassUtil;
use Application\Utils\ExceptionUtil;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class GameSessionCreate
 * @package Application\Console\RateSeatApi\Command\Admin
 */
class GameSessionCreateConsoleCommand extends BaseConsoleCommand
{

    /*

    Example:

    php console/whow-api/run.php admin:GameSession:create


    */

    const COMMAND_NAME = 'admin:GameSession:create';

    const OPTION_NAME_GAME_ID='gameId';
    const OPTION_NAME_USER_ID='userId';
    /**
     *
     */
    protected function configure()
    {
        $this->setName($this::COMMAND_NAME)
            ->setDescription(
                ''
                . ClassUtil::getClassNameAsJavaStyle($this)
            )

        ->addOption(
            $this::OPTION_NAME_GAME_ID, null, InputOption::VALUE_REQUIRED
            )
            ->addOption(
                $this::OPTION_NAME_USER_ID, null, InputOption::VALUE_REQUIRED
            )

        ;
    }

    /**
     * @return int
     * @throws \Exception
     */

    protected function executeCommand()
    {
        $result = 0;

        try {

            $optionName=$this::OPTION_NAME_GAME_ID;
            $optionValue = $this->getInput()->getOption($optionName);

            $gameIdValue = $optionValue;
            if(empty($optionValue)) {

                throw new \Exception(
                    'Invalid value for option: '.$optionName.' !'
                    .' Must be WhowGameIdType - not empty!'
                );
            }

            $optionName=$this::OPTION_NAME_USER_ID;
            $optionValue = $this->getInput()->getOption($optionName);

            $userIdValue = $optionValue;
            if(empty($optionValue)) {

                throw new \Exception(
                    'Invalid value for option: '.$optionName.' !'
                    .' Must be WhowUserIdType - not empty!'
                );
            }

            $request = array(
                'userId'=>$userIdValue,
                'gameId'=>$gameIdValue,
            );

            $this->echoLn('API REQUEST ...', 2);

            $this->echoLn(json_encode($request), 2);

            $rpcContext = new RpcContext();
            $requestHandler = new GameSessionCreateRequestHandler(
                $rpcContext
            );

            $startTs = microtime(true);
            $responseResult = $requestHandler->handleRequest($request);
            $stopTs = microtime(true);
            $response = array(
                'result'=>$responseResult,
                'duration'=>$stopTs-$startTs,
            );


            $this->echoLn('API RESPONSE ...', 2);
            $this->echoLn(json_encode($response), 2);

            $this->echoLn('done.', 2);


        } catch (\Exception $e) {

            $this->echoLn('EXCEPTION !', 2);

            $this->echoLn(json_encode(ExceptionUtil::exceptionAsArray($e, true)), 2);

            throw $e;
        }


        return $result;
    }


}