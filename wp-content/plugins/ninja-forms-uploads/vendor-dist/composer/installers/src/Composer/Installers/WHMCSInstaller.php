<?php

namespace NF_FU_VENDOR\Composer\Installers;

class WHMCSInstaller extends \NF_FU_VENDOR\Composer\Installers\BaseInstaller
{
    protected $locations = array('gateway' => 'modules/gateways/{$name}/');
}
