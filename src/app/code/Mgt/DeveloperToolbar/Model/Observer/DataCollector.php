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
use Magento\Framework\Registry;
use Magento\Framework\DataObject;
use Magento\Framework\View\LayoutInterface as Layout;
use Magento\Framework\App\CacheInterface as Cache;
use Magento\Framework\UrlInterface as Url;
use Magento\Framework\App\Request\Http as Request;
use Magento\Framework\App\Response\Http as Response;
use Magento\Framework\Stdlib\CookieManagerInterface as CookieManager;
use Magento\Framework\Event\Manager as EventManager;
use Magento\Framework\Interception\PluginList\PluginList;
use Magento\Framework\Interception\DefinitionInterface;
use Magento\Framework\ObjectManager\ConfigInterface as ObjectManagerConfig;
use Magento\Framework\App\State as AppState;

use Mgt\DeveloperToolbar\Model\Config;

class DataCollector implements ObserverInterface
{
    const CACHE_ID_PREFIX = 'MGT_DEVELOPER_TOOLBAR_PROFILE';
    const CACHE_TAG = 'MGT_DEVELOPER_TOOLBAR';
    const CONTROLLER_ACTION_NAME = 'execute';
    
    /**
     * @var \Mgt\DeveloperToolbar\Model\Config
     */
    protected $config;
    
    /**
     * @var \Magento\Framework\DataObject
     */
    protected $layout;
    
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;
    
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;
    
    /**
     * @var \Magento\Framework\DataObject
     */
    protected $data;
    
    /**
     * @var \Magento\Framework\App\CacheInterface
     */
    protected $cache;
    
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;
    
    /**
     * @var \Magento\Framework\App\Response\Http
     */
    protected $response;
    
    /**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface
     */
    protected $cookiesManager;
    
    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager;
    
    /**
     * @var \Magento\Framework\Interception\PluginList\PluginList
     */
    protected $pluginList;
    
    /**
     * @var \Magento\Framework\ObjectManager\ConfigInterface
     */
    protected $objectManagerConfig;
    
    /**
     * @var \Magento\Framework\App\State
     */
    protected $appState;

    /**
     * @param \Mgt\DeveloperToolbar\Model\Config $config
     * @param \Magento\Framework\View\LayoutInterface $layout
     * @param \Magento\Framework\UrlInterface $url
     * @param \Magento\Framework\View\LayoutInterface $url
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\DataObject $data
     * @param \Magento\Framework\App\CacheInterface $cache
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\App\Response\Http $response
     * @param \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     * @param \Magento\Framework\Event\Manager $eventManager
     * @param \Magento\Framework\Interception\PluginList\PluginList $pluginList
     * @param \Magento\Framework\ObjectManager\ConfigInterface $objectManagerConfig
     * @param \Magento\Framework\App\State $appState
     */
    public function __construct(
        Config $config,
        Layout $layout,
        Registry $registry,
        Url $url,
        Cache $cache,
        DataObject $data,
        Request $request,
        Response $response,
        CookieManager $cookieManager,
        EventManager $eventManager,
        PluginList $pluginList,
        ObjectManagerConfig $objectManagerConfig,
        AppState $appState
    ) {
        $this->config = $config;
        $this->layout = $layout;
        $this->url = $url;
        $this->registry = $registry;
        $this->cache = $cache;
        $this->data = $data;
        $this->request = $request;
        $this->response = $response;
        $this->cookieManager = $cookieManager;
        $this->eventManager = $eventManager;
        $this->pluginList = $pluginList;
        $this->objectManagerConfig = $objectManagerConfig;
        $this->appState = $appState;
    }
    
    public function execute(Observer $observer)
    {
        $isEnabled = $this->config->isEnabled();
        $collect = $this->registry->registry('mgt_developer_toolbar_collect');
        if (true === $isEnabled && false !== $collect) {
            $this->collectInformation();
        }
    }
    
    protected function collectInformation()
    {
        $toolbarBlock = $this->layout->getBlock('mgt_developer_toolbar');
        $phpParseTimeBlock = $this->layout->getBlock('mgt_developer_toolbar_block_php_parse_time');
        $memoryConsumptionBlock = $this->layout->getBlock('mgt_developer_toolbar_block_memory_consumption');
        $databaseQueriesBlock = $this->layout->getBlock('mgt_developer_toolbar_block_database_queries');

        if (!$toolbarBlock) {
            return;
        }
        
        $token = $toolbarBlock->getToken();
        $this->registry->register('mgt_developer_toolbar_token', $token);
        
        $currentUrl = $this->url->getCurrentUrl();
        $phpParseTime = $phpParseTimeBlock->getPhpParseTime();
        $memoryConsumption = $memoryConsumptionBlock->getMemoryConsumption();
        $totalElapsedSecs = $databaseQueriesBlock->getTotalElapsedSecs();
        $totalNumberOfQueries = $databaseQueriesBlock->getTotalNumQueries();

        $requestGetParameters = (array)$this->request->getParams(); 
        $requestPostParameters = (array)$this->request->getPost();
        
        $controllerModule = $this->request->getControllerModule();
        $controllerFullActionName = $this->request->getFullActionName();
        $controllerClassName = $this->registry->registry('mgt_developer_toolbar_class_name');

        $requestHeaders = $this->request->getHeaders()->toArray();
        $requestAttributes = [
            'Controller Module'          => $controllerModule,
            'Controller ClassName'       => $controllerClassName,
            'Controller Full ActionName' => $controllerFullActionName, 
            'Controller ActionName'      => self::CONTROLLER_ACTION_NAME,
            'Path Info'                  => $this->request->getPathInfo(),
        ];

        $blocks = $this->buildBlocks();
        $layoutHandles = $this->layout->getUpdate()->getHandles();

        $events = $this->getEvents();
        $plugins = $this->getPlugins();
        $preferences = $this->getPreferences();

        $this->data->setData('areaCode', $this->appState->getAreaCode());
        $this->data->setData('currentUrl', $currentUrl);
        $this->data->setData('phpParseTime', $phpParseTime);
        $this->data->setData('memoryConsumption', $memoryConsumption);
        $this->data->setData('totalElapsedSecs', $totalElapsedSecs);
        $this->data->setData('totalNumberOfQueries', $totalNumberOfQueries);
        
        $this->data->setData('controllerModule', $controllerModule);
        $this->data->setData('controllerActionName', self::CONTROLLER_ACTION_NAME);
        $this->data->setData('controllerFullActionName', $controllerFullActionName);
        $this->data->setData('controllerClassName', $controllerClassName);
        $this->data->setData('requestAttributes', $requestAttributes);
        $this->data->setData('requestHeaders', $requestHeaders);
        $this->data->setData('serverParameters', $_SERVER);
        
        $this->data->setData('requestGetParameters', $requestGetParameters);
        $this->data->setData('requestPostParameters', $requestPostParameters);
        $this->data->setData('cookies', $_COOKIE);
        
        $this->data->setData('blocks', $blocks);
        $this->data->setData('layoutHandles', $layoutHandles);
        $this->data->setData('events', $events);
        $this->data->setData('plugins', $plugins);
        $this->data->setData('preferences', $preferences);

        $data = $this->data->getData();

        $cacheId = sprintf('%s_%s', self::CACHE_ID_PREFIX, $token);
        $this->cache->save(serialize($data), $cacheId, [self::CACHE_TAG]);
    }
    
    protected function getEvents()
    {
        $reflectionClass = new \ReflectionClass($this->eventManager);
        $reflectionProperty = $reflectionClass->getProperty('_eventConfig');
        $reflectionProperty->setAccessible(true);
        $eventConfig = $reflectionProperty->getValue($this->eventManager);

        $reflectionClass = new \ReflectionClass($eventConfig);
        $reflectionProperty = $reflectionClass->getProperty('_dataContainer');
        $reflectionProperty->setAccessible(true);
        
        $dataContainer = $reflectionProperty->getValue($eventConfig);
        $events = $dataContainer->get();
        return $events;
    }
    
    protected function getPlugins()
    {
        $reflectionClass = new \ReflectionClass($this->pluginList);
        $pluginInstancesProperty = $reflectionClass->getProperty('_pluginInstances');
        $pluginInstancesProperty->setAccessible(true);
        $definitionsProperty = $reflectionClass->getProperty('_definitions');
        $definitionsProperty->setAccessible(true);
        $pluginInstances = $pluginInstancesProperty->getValue($this->pluginList);
        $definitions = $definitionsProperty->getValue($this->pluginList);
        $plugins = [];
        
        foreach ($pluginInstances as $pluginInstanceClass => $children) {
            foreach ($children as $childName => $childInstance) {
                $methodTypes = $definitions->getMethodList($childInstance);
                $listener = '';
                foreach ($methodTypes as $methodType) {
                    switch ($methodType) {
                        case DefinitionInterface::LISTENER_AROUND:
                            $listener = 'Around';
                        break;
                        case DefinitionInterface::LISTENER_BEFORE:
                            $listener = 'Before';
                        break;
                        case DefinitionInterface::LISTENER_AFTER:
                            $listener = 'After';
                        break;
                    }
                    break;
                }
                $plugins[$pluginInstanceClass][] = [
                   'name'      => $childName,
                   'listener'  => $listener,
                   'className' => get_class($childInstance)
                ];
            }
        }
        
        return $plugins;
    }
    
    protected function getPreferences()
    {
        $reflectionClass = new \ReflectionClass($this->objectManagerConfig);
        $preferences = [];
        if ($this->objectManagerConfig instanceof \Magento\Framework\Interception\ObjectManager\Config\Compiled) {
            $parentClass = $reflectionClass->getParentClass();
            $preferencesProperty = $parentClass->getProperty('preferences');
            $preferencesProperty->setAccessible(true);
            $preferences = $preferencesProperty->getValue($this->objectManagerConfig);
        } else {
            $preferencesProperty = $reflectionClass->getProperty('_preferences');
            $preferencesProperty->setAccessible(true);
            $preferences = $preferencesProperty->getValue($this->objectManagerConfig);
        }
        return $preferences;
    }
    
    protected function buildBlocks($parent = 'root')
    {
        $_blocks = array();
        $blocks = $this->layout->getChildNames($parent);
        
        if (count($blocks)) {
            
            foreach ($blocks as $blockName) {
                
                $block = $this->layout->getBlock($blockName);
                $template = '';
                $class = '';
                $fileName = '';
                
                if (false !== $block) {
                    $template = $block->getTemplateFile();
                    $class = get_class($block);
                    $reflectionClass = new \ReflectionClass($block);
                    $fileName =  $reflectionClass->getFileName();
                }
                
                $_blocks[$blockName] = [
                    'name'      => $blockName,
                    'template'  => $template,
                    'class'     => $class,
                    'fileName'  => $fileName,
                ];
                
                $children = $this->layout->getChildNames($blockName);
                
                if (count($children)) {
                    $_blocks[$blockName]['children'] = $this->buildBlocks($blockName);
                }
            }
            
        }
        return $_blocks;
    }
}