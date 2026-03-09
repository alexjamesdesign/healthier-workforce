<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NF_FU_VENDOR\Symfony\Component\Console\EventListener;

use NF_FU_VENDOR\Psr\Log\LoggerInterface;
use NF_FU_VENDOR\Symfony\Component\Console\ConsoleEvents;
use NF_FU_VENDOR\Symfony\Component\Console\Event\ConsoleErrorEvent;
use NF_FU_VENDOR\Symfony\Component\Console\Event\ConsoleEvent;
use NF_FU_VENDOR\Symfony\Component\Console\Event\ConsoleTerminateEvent;
use NF_FU_VENDOR\Symfony\Component\EventDispatcher\EventSubscriberInterface;
/**
 * @author James Halsall <james.t.halsall@googlemail.com>
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class ErrorListener implements \NF_FU_VENDOR\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $logger;
    public function __construct(\NF_FU_VENDOR\Psr\Log\LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }
    public function onConsoleError(\NF_FU_VENDOR\Symfony\Component\Console\Event\ConsoleErrorEvent $event)
    {
        if (null === $this->logger) {
            return;
        }
        $error = $event->getError();
        if (!($inputString = $this->getInputString($event))) {
            return $this->logger->error('An error occurred while using the console. Message: "{message}"', ['exception' => $error, 'message' => $error->getMessage()]);
        }
        $this->logger->error('Error thrown while running command "{command}". Message: "{message}"', ['exception' => $error, 'command' => $inputString, 'message' => $error->getMessage()]);
    }
    public function onConsoleTerminate(\NF_FU_VENDOR\Symfony\Component\Console\Event\ConsoleTerminateEvent $event)
    {
        if (null === $this->logger) {
            return;
        }
        $exitCode = $event->getExitCode();
        if (0 === $exitCode) {
            return;
        }
        if (!($inputString = $this->getInputString($event))) {
            return $this->logger->debug('The console exited with code "{code}"', ['code' => $exitCode]);
        }
        $this->logger->debug('Command "{command}" exited with code "{code}"', ['command' => $inputString, 'code' => $exitCode]);
    }
    public static function getSubscribedEvents()
    {
        return [\NF_FU_VENDOR\Symfony\Component\Console\ConsoleEvents::ERROR => ['onConsoleError', -128], \NF_FU_VENDOR\Symfony\Component\Console\ConsoleEvents::TERMINATE => ['onConsoleTerminate', -128]];
    }
    private static function getInputString(\NF_FU_VENDOR\Symfony\Component\Console\Event\ConsoleEvent $event)
    {
        $commandName = $event->getCommand() ? $event->getCommand()->getName() : null;
        $input = $event->getInput();
        if (\method_exists($input, '__toString')) {
            if ($commandName) {
                return \str_replace(["'{$commandName}'", "\"{$commandName}\""], $commandName, (string) $input);
            }
            return (string) $input;
        }
        return $commandName;
    }
}
