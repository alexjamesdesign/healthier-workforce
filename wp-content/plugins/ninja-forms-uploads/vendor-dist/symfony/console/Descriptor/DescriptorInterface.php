<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NF_FU_VENDOR\Symfony\Component\Console\Descriptor;

use NF_FU_VENDOR\Symfony\Component\Console\Output\OutputInterface;
/**
 * Descriptor interface.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface DescriptorInterface
{
    /**
     * Describes an object if supported.
     *
     * @param OutputInterface $output
     * @param object          $object
     * @param array           $options
     */
    public function describe(\NF_FU_VENDOR\Symfony\Component\Console\Output\OutputInterface $output, $object, array $options = []);
}
