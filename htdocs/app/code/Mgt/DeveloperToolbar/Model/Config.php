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
namespace Mgt\DeveloperToolbar\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\DeploymentConfig\Writer as DeploymentConfigWriter;
use Magento\Framework\App\DeploymentConfig\Reader as DeploymentConfigReader;
use Magento\Config\Model\Config\Factory as ConfigFactory;

class Config
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var DeploymentConfigWriter
     */
    protected $deploymentConfigWriter;

    /**
     * @var DeploymentConfigWriter
     */
    protected $deploymentConfigReader;

    /**
     * @var ConfigFactory
     */
    protected $configFactory;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param DeploymentConfigWriter $deploymentConfigWriter
     * @param DeploymentConfigReader $deploymentConfigReader
     * @param ConfigFactory $configFactory
     */
    public function __construct(
        DeploymentConfigWriter $deploymentConfigWriter,
        DeploymentConfigReader $deploymentConfigReader,
        ScopeConfigInterface $scopeConfig,
        ConfigFactory $configFactory
    ) {
        $this->deploymentConfigWriter = $deploymentConfigWriter;
        $this->deploymentConfigReader = $deploymentConfigReader;
        $this->scopeConfig = $scopeConfig;
        $this->configFactory = $configFactory;
    }
    
    public function isEnabled()
    {
        $isEnabled = (bool)$this->scopeConfig->getValue('mgt_developer_toolbar/module/is_enabled');
        return $isEnabled;
    }
    
    public function getAllowedIps()
    {
        $allowedIps = trim($this->scopeConfig->getValue('mgt_developer_toolbar/module/allowed_ip'));
        $allowedIps = array_map('trim', explode(',', $allowedIps));
        $allowedIps = array_filter($allowedIps);
        return $allowedIps;
    }
}