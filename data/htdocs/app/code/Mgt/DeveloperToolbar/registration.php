<?php

if (PHP_SAPI != 'cli') {
    $_SERVER['MAGE_PROFILER_STAT'] = new \Mgt\DeveloperToolbar\Model\Profiler\Driver\Standard\Stat();
    \Magento\Framework\Profiler::applyConfig(
        [
            'drivers' => [
                [
                    'output' => 'Mgt\DeveloperToolbar\Model\Driver\Output\Zero',
                    'stat'   => $_SERVER['MAGE_PROFILER_STAT'],
                ]
            ]
        ],
        BP,
        false
    );
}

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Mgt_DeveloperToolbar',
    __DIR__
);