<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/20/13
 * Time: 12:02 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Console\Base;

use Application\Context;
use Application\Utils\ClassUtil;
use Symfony\Component\Console\Command\Command as AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BaseConsoleCommand
 *
 * @package Application\Console\Base
 */
class BaseConsoleCommand extends AbstractCommand
{

    const COMMAND_NAME = 'base:command';

    const INPUT_OPTION_VALUE_REQUIRED = InputOption::VALUE_REQUIRED;
    const INPUT_OPTION_VALUE_OPTIONAL = InputOption::VALUE_OPTIONAL;
    const INPUT_OPTION_VALUE_NONE = InputOption::VALUE_NONE;
    const INPUT_OPTION_VALUE_IS_ARRAY = InputOption::VALUE_IS_ARRAY;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param InputInterface $input
     *
     * @return $this
     */
    public function setInput(InputInterface $input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function setOutput(OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * @return OutputInterface
     */
    protected function getOutput()
    {
        return $this->output;
    }


    /**
     *
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription(
                ' do magic stuff: '
                . ' : ' . ClassUtil::getQualifiedMethodName(
                    $this,
                    __METHOD__,
                    true
                )
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->setInput($input);
        $this->setOutput($output);

        try {
            $resultCode = (int)$this->executeCommand();

            return $resultCode;
        } catch (\Exception $e) {
            $this->onError($e);
        }


    }

    /**
     * @return int
     */
    protected function executeCommand()
    {
        $this->echoLn(
            ClassUtil::getQualifiedMethodName($this, __METHOD__, true)
        );

        return 0;
    }

    /**
     * @param \Exception $exception
     * @throws \Exception
     */
    protected function onError(\Exception $exception)
    {
        $this->echoLn(
            ClassUtil::getQualifiedMethodName($this, __METHOD__, true)
            . ' : ERROR: '
            . ' file: ' . $exception->getFile()
            . ' line: ' . $exception->getLine()
            . ' class: ' . ClassUtil::getClassNameAsJavaStyle($exception)
            . ' message: ' . $exception->getMessage()


        );

        throw $exception;
    }

    /**
     * @param string $message
     * @param int|null $lineCount
     *
     * @return $this
     */
    protected function echoLn($message, $lineCount = null)
    {
        if ($lineCount == null) {
            $lineCount = 1;
        }
        $lineCount = (int)$lineCount;

        echo $message;
        if ($lineCount < 1) {

            return $this;
        }

        for ($i = 0; $i < $lineCount; $i++) {

            echo PHP_EOL;
        }

        return $this;
    }

    /**
     * @return Context
     */
    protected function getApplicationContext()
    {
        return Context::getInstance();
    }

}