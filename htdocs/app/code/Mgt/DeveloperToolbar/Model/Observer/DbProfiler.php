<?php
/**
 * MGT-Commerce GmbH
 * https://www.mgt-commerce.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@mgt-commerce.com so we can send you a copy immediately.
 *
 * @category    Mgt
 * @package     Mgt_DeveloperToolbar
 * @author      Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 * @copyright   Copyright (c) 2016 (https://www.mgt-commerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mgt\DeveloperToolbar\Model\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\DeploymentConfig\Writer as DeploymentConfigWriter;
use Magento\Framework\App\DeploymentConfig\Reader as DeploymentConfigReader;
use Magento\Framework\Config\File\ConfigFilePool;

use Mgt\DeveloperToolbar\Model\Config;

class DbProfiler implements ObserverInterface
{
    /**
     * @var \Mgt\DeveloperToolbar\Model\Config
     */
    protected $config;

    /**
     * @var DeploymentConfigWriter
     */
    protected $deploymentConfigWriter;
    
    /**
     * @var DeploymentConfigWriter
     */
    protected $deploymentConfigReader;
    
    /**
     * @param \Mgt\DeveloperToolbar\Model\Config $config
     * @param \Magento\Framework\App\DeploymentConfig\Writer $deploymentConfigWriter
     * @param \Magento\Framework\App\DeploymentConfig\Read $deploymentConfigReader

     */
    public function __construct(
        Config $config,
        DeploymentConfigWriter &$deploymentConfigWriter,
        DeploymentConfigReader &$deploymentConfigReader
    ) {
        $this->config = $config;
        $this->deploymentConfigWriter = $deploymentConfigWriter;
        $this->deploymentConfigReader = $deploymentConfigReader;
    }
    
    public function execute(Observer $observer)
    {
        $isEnabled = $this->config->isEnabled();
        $env = $this->deploymentConfigReader->load(ConfigFilePool::APP_ENV);
        
        if (true === $isEnabled) {
            $env['db']['connection']['default']['profiler'] = [
                'class'   => '\\Magento\\Framework\\DB\\Profiler',
                'enabled' => true
            ];
        } else {
            unset($env['db']['connection']['default']['profiler']);
        }

        $this->deploymentConfigWriter->saveConfig([ConfigFilePool::APP_ENV => $env], true);
    }
}