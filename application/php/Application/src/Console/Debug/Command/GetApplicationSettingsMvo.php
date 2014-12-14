<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/25/14
 * Time: 8:40 AM
 */

namespace Application\Console\Debug\Command;


use Application\Console\Base\BaseConsoleCommand;
use Application\Mvo\ApplicationSettings\ApplicationSettingsMvo;
use Application\Utils\ClassUtil;


/**
 * Class GetApplicationSettingsMvo
 *
 * @package Application\Console\Debug\Command
 */
class GetApplicationSettingsMvo extends BaseConsoleCommand
{

    /*

    EXAMPLE:
    ========

    php console/debug/run.php debug:getApplicationSettingsMvo

    */


    const COMMAND_NAME = 'debug:getApplicationSettingsMvo';


    /**
     *
     */
    protected function configure()
    {
        $this->setName( $this::COMMAND_NAME )
             ->setDescription(
                 ''
                 . ClassUtil::getClassNameAsJavaStyle( $this )
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


            $mvo = new ApplicationSettingsMvo();

            var_dump( '======= load...' );

            $mvo->load();
            $mvo->requireIsLoaded(
                'Failed to load mvo !'
                . ' ' . ClassUtil::getQualifiedMethodName( $mvo, 'memId', true )
                . ' =' . $mvo->getMvoMemId() . ' !'
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


            $this->echoLn( 'application settings (json) ... ', 2 );
            $this->echoLn( json_encode( $mvo->getData() ), 2 );


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