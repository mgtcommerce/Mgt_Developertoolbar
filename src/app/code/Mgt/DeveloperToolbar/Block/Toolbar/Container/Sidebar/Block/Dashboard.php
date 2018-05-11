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
namespace Mgt\DeveloperToolbar\Block\Toolbar\Container\Sidebar\Block;

use Magento\Framework\Module\ModuleList;
use Magento\Framework\Module\FullModuleList;
use Magento\Framework\Session\Config as SessionConfig;
use Magento\Framework\App\ResourceConnection;

use Mgt\DeveloperToolbar\Block\Context;
use Mgt\DeveloperToolbar\Block\Toolbar\Container\Sidebar\Block;

class Dashboard extends Block
{
    /**
     * @var String
     */
    protected $label = 'Dashboard';

    /**
     * @var \Magento\Framework\Module\ModuleList
     */
    protected $moduleList;
    
    /**
     * @var \Magento\Framework\Module\FullModuleList
     */
    protected $fullModuleList;
    
    /**
     * Session config
     *
     * @var \Magento\Framework\Session\Config
     */
    protected $sessionConfig;
    
    /**
     *  Resource Connection
     *
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resourceConnection;
    
    /**
     * @var Array
     */
    protected $modules = [];
    
    /**
     * @var String
     */
    protected $areaCode;
    
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetaData;
    
    /**
     * @var \Magento\Framework\App\CacheInterface
     */
    protected $cache;

    /**
     * @param Context $context
     * @param ModuleList $moduleList
     */
    public function __construct(
        Context $context,
        ModuleList $moduleList,
        FullModuleList $fullModuleList,
        SessionConfig $sessionConfig,
        ResourceConnection $resourceConnection
    ) {
        $this->moduleList = $moduleList;
        $this->fullModuleList = $fullModuleList;
        $this->sessionConfig = $sessionConfig;
        $this->resourceConnection = $resourceConnection;
        $this->productMetaData = $context->getProductMetaData();
        parent::__construct($context);
    }
    
    public function getModules()
    {
        if (!$this->modules) {
            $enabledModules = $this->getEnabledModules();
            $disabledModules = $this->getDisabledModules();
            foreach ($enabledModules as $module) {
                $this->modules[$module] = true;
            }
            foreach ($disabledModules as $module) {
                $this->modules[$module] = false;
            }
        }
        return $this->modules;
    }
    
    protected function getEnabledModules()
    {
        return $this->moduleList->getNames();
    }
    
    protected function getDisabledModules()
    {
        $enabledModules = $this->getEnabledModules();
        $disabledModules = array_diff($this->fullModuleList->getNames(), $enabledModules);
        return $disabledModules;
    }
    
    public function getMode()
    {
        return $this->_appState->getMode();
    }
    
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;
    }
    
    public function getAreaCode()
    {
        return $this->areaCode;
    }
    
    public function getMagentoVersion()
    {
        $productMetaData = $this->getProductMetaData();
        $magentoVersion = $productMetaData->getVersion();
        return $magentoVersion;
    }
    
    public function getSessionSaveHandler()
    {
        $sessionConfigOptions = $this->sessionConfig->getOptions();
        $sessionSaveHandler = isset($sessionConfigOptions['session.save_handler']) ? $sessionConfigOptions['session.save_handler'] : '';
        return $sessionSaveHandler;
    }
    
    public function getCacheStorage()
    {
        $cache = $this->getCache();
        $cacheFrontend = $cache->getFrontend();
        $cacheBackend = $cacheFrontend->getBackend();
        $cacheStorage = explode('_', get_class($cacheBackend));
        $cacheStorage = end($cacheStorage);
        return $cacheStorage;
    }
    
    protected function getCache()
    {
        if (!$this->cache) {
            $this->cache = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\CacheInterface');
        }
        return $this->cache;
    }
    
    public function getPhpVersion()
    {
        $phpVersion = phpversion();
        return $phpVersion;
    }
    
    public function getPhpMemoryLimit()
    {
        $convertToBytes = function($value) {
            $value = trim($value);
            $last = strtolower($value[strlen($value)-1]);
            $value = (int)$value;
            switch($last) {
                case 'g':
                    $value *= 1024;
                case 'm':
                    $value *= 1024;
                case 'k':
                    $value *= 1024;
            }
        
            return $value;
        };
        $phpMemoryLimit = $convertToBytes(ini_get('memory_limit'));
        return $phpMemoryLimit;
    }
    
    public function getPhpMaxExecutionTime()
    {
        $phpMaxExecutionTime = ini_get('max_execution_time');
        return $phpMaxExecutionTime;
    }
    
    public function getMysqlVersion()
    {
        $readConnection = $this->resourceConnection->getConnection('read');
        $mysqlVersion = $readConnection->query('select version()')->fetchColumn();
        $mysqlVersion = mb_substr($mysqlVersion, 0, 6);
        return $mysqlVersion;
    }
    
    public function getProductMetaData()
    {
        return $this->productMetaData;
    }
}
