<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NF_FU_VENDOR\Symfony\Component\Console\Event;

use NF_FU_VENDOR\Symfony\Component\Console\Command\Command;
use NF_FU_VENDOR\Symfony\Component\Console\Input\InputInterface;
use NF_FU_VENDOR\Symfony\Component\Console\Output\OutputInterface;
use NF_FU_VENDOR\Symfony\Component\EventDispatcher\Event;
/**
 * Allows to inspect input and output of a command.
 *
 * @author Francesco Levorato <git@flevour.net>
 */
class ConsoleEvent extends \NF_FU_VENDOR\Symfony\Component\EventDispatcher\Event
{
    protected $command;
    private $input;
    private $output;
    public function __construct(\NF_FU_VENDOR\Symfony\Component\Console\Command\Command $command = null, \NF_FU_VENDOR\Symfony\Component\Console\Input\InputInterface $input, \NF_FU_VENDOR\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $this->command = $command;
        $this->input = $input;
        $this->output = $output;
    }
    /**
     * Gets the command that is executed.
     *
     * @return Command|null A Command instance
     */
    public function getCommand()
    {
        return $this->command;
    }
    /**
     * Gets the input instance.
     *
     * @return InputInterface An InputInterface instance
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * Gets the output instance.
     *
     * @return OutputInterface An OutputInterface instance
     */
    public function getOutput()
    {
        return $this->output;
    }
}
