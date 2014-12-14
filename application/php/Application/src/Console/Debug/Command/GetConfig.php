<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/20/13
 * Time: 12:00 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Console\Debug\Command;

use Application\Console\Base\BaseConsoleCommand;
use Application\Utils\ClassUtil;

/**
 * Class GetConfig
 *
 * @package Application\Console\Debug\Command
 */
class GetConfig extends BaseConsoleCommand
{

    /*

    Example:

    php console/debug/run.php debug:getConfig


    */

    const COMMAND_NAME = 'debug:getConfig';

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
            $configVo = $this->getApplicationContext()
                             ->getModel()
                             ->getConfigVo();
            $config   = $configVo
                ->getData();

            $this->echoLn( 'config ... ', 2 );
            var_dump( $config );

            $this->echoLn( 'config (json) ... ', 2 );
            $this->echoLn( json_encode( $config ), 2 );

            $configVo->validate();

            $this->echoLn( 'Config successfully loaded and validated.', 2 );


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