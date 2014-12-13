<?php

namespace Application\test\Example;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ExampleCommandTest
 *
 * @package Application\test\Example
 */
class ExampleCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return $this
     */
    public function testExecute()
    {
        $application = new Application("demo:greet");
        $command = $application->add(new ExampleCommand());

        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array('command' => $command->getName(), 'name' => 'Irina')
        );

        $this->assertRegExp('/Irina/', $commandTester->getDisplay());

    }
} 