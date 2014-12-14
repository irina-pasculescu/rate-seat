<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 6:20 PM
 */

namespace Application\Console\Debug\Command;


use Application\Console\Base\BaseConsoleCommand;
use Application\Definition\StringStrictNotEmptyType;
use Application\Definition\UintTypeNotEmpty;
use Application\Mvo\Example\ExampleEventMvo;
use Application\Utils\ClassUtil;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class TestExampleMvo
 *
 * @package Application\Console\Debug\Command
 */
class TestExampleMvo extends BaseConsoleCommand
{

    /*

    EXAMPLE:
    ========

    php console/debug/run.php debug:testExampleMvo --event-name="foo" --event-created-at=1

    */


    const COMMAND_NAME = 'debug:testExampleMvo';

    const OPTION_NAME_EVENT_NAME       = 'event-name';
    const OPTION_NAME_EVENT_CREATED_AT = 'event-created-at';


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
                 $this::OPTION_NAME_EVENT_NAME,
                 null,
                 InputOption::VALUE_REQUIRED
             )
             ->addOption(
                 $this::OPTION_NAME_EVENT_CREATED_AT,
                 null,
                 InputOption::VALUE_REQUIRED
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

            $optionName = $this::OPTION_NAME_EVENT_NAME;
            $eventName  = $this->getInput()->getOption(
                $optionName
            );
            new StringStrictNotEmptyType(
                $eventName,
                'Option ' . $optionName . ' must be a string not empty!'
            );

            $optionName     = $this::OPTION_NAME_EVENT_CREATED_AT;
            $eventCreatedAt = $this->getInput()->getOption(
                $optionName
            );
            new StringStrictNotEmptyType(
                $eventName,
                'Option ' . $optionName . ' must be a uint not empty!'
            );

            $mvo = new ExampleEventMvo();

            var_dump( '======= load...' );

            $mvo->load(
                new StringStrictNotEmptyType( $eventName ),
                new UintTypeNotEmpty( $eventCreatedAt )
            );

            var_dump(
                array(
                    'memId'            => $mvo->getMvoMemId(),
                    'hasData'          => $mvo->hasData(),
                    'hasMvoDataLoaded' => $mvo->hasMvoDataLoaded(),
                    'isLoaded'         => $mvo->isMvoLoaded(),
                    'isDirty'          => $mvo->isMvoDirty(),
                    'data'             => $mvo->getData(),
                )
            );

            var_dump( '======= modify...' );

            $mvo->setDescription(
                new StringStrictNotEmptyType(
                    'my_description_' . microtime(
                        true
                    )
                )
            );

            var_dump(
                array(
                    'memId'            => $mvo->getMvoMemId(),
                    'hasData'          => $mvo->hasData(),
                    'hasMvoDataLoaded' => $mvo->hasMvoDataLoaded(),
                    'isLoaded'         => $mvo->isMvoLoaded(),
                    'isDirty'          => $mvo->isMvoDirty(),
                    'data'             => $mvo->getData(),
                )
            );

            var_dump( '======= save...' );
            $mvo->save(
                new StringStrictNotEmptyType( $eventName ),
                new UintTypeNotEmpty( $eventCreatedAt )
            );
            var_dump(
                array(
                    'memId'            => $mvo->getMvoMemId(),
                    'ttl'              => $mvo->getMvoTtl(),
                    'hasData'          => $mvo->hasData(),
                    'hasMvoDataLoaded' => $mvo->hasMvoDataLoaded(),
                    'isLoaded'         => $mvo->isMvoLoaded(),
                    'isDirty'          => $mvo->isMvoDirty(),
                    'data'             => $mvo->getData(),
                )
            );

            var_dump( '======= reload...' );
            $mvo = new ExampleEventMvo();
            $mvo->load(
                new StringStrictNotEmptyType( $eventName ),
                new UintTypeNotEmpty( $eventCreatedAt )
            );
            var_dump(
                array(
                    'memId'            => $mvo->getMvoMemId(),
                    'ttl'              => $mvo->getMvoTtl(),
                    'hasData'          => $mvo->hasData(),
                    'hasMvoDataLoaded' => $mvo->hasMvoDataLoaded(),
                    'isLoaded'         => $mvo->isMvoLoaded(),
                    'isDirty'          => $mvo->isMvoDirty(),
                    'data'             => $mvo->getData(),
                )
            );

        }
        catch (\Exception $e) {

            var_dump( $e );
            var_dump( get_class( $e ) );
            var_dump( $e->getMessage() );

            throw $e;
        }


        return $result;
    }


}