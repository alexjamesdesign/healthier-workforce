<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NF_FU_VENDOR\Symfony\Component\Console\Command;

use NF_FU_VENDOR\Symfony\Component\Console\Exception\LogicException;
use NF_FU_VENDOR\Symfony\Component\Lock\Factory;
use NF_FU_VENDOR\Symfony\Component\Lock\Lock;
use NF_FU_VENDOR\Symfony\Component\Lock\Store\FlockStore;
use NF_FU_VENDOR\Symfony\Component\Lock\Store\SemaphoreStore;
/**
 * Basic lock feature for commands.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
trait LockableTrait
{
    /** @var Lock */
    private $lock;
    /**
     * Locks a command.
     *
     * @return bool
     */
    private function lock($name = null, $blocking = \false)
    {
        if (!\class_exists(\NF_FU_VENDOR\Symfony\Component\Lock\Store\SemaphoreStore::class)) {
            throw new \NF_FU_VENDOR\Symfony\Component\Console\Exception\LogicException('To enable the locking feature you must install the symfony/lock component.');
        }
        if (null !== $this->lock) {
            throw new \NF_FU_VENDOR\Symfony\Component\Console\Exception\LogicException('A lock is already in place.');
        }
        if (\NF_FU_VENDOR\Symfony\Component\Lock\Store\SemaphoreStore::isSupported()) {
            $store = new \NF_FU_VENDOR\Symfony\Component\Lock\Store\SemaphoreStore();
        } else {
            $store = new \NF_FU_VENDOR\Symfony\Component\Lock\Store\FlockStore();
        }
        $this->lock = (new \NF_FU_VENDOR\Symfony\Component\Lock\Factory($store))->createLock($name ?: $this->getName());
        if (!$this->lock->acquire($blocking)) {
            $this->lock = null;
            return \false;
        }
        return \true;
    }
    /**
     * Releases the command lock if there is one.
     */
    private function release()
    {
        if ($this->lock) {
            $this->lock->release();
            $this->lock = null;
        }
    }
}
