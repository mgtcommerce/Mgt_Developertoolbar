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
namespace Mgt\DeveloperToolbar\Helper;

use Magento\Framework\App\Action\Action;

class Toolbar extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CACHE_ID_PREFIX = 'MGT_DEVELOPER_TOOLBAR_PROFILE';
    const CACHE_ID_TIMERS_PREFIX = 'MGT_DEVELOPER_TOOLBAR_PROFILE_TIMERS';
    const CACHE_ID_QUERIES_PREFIX = 'MGT_DEVELOPER_TOOLBAR_QUERIES';
    
    /**
     * Design package instance
     *
     * @var \Magento\Framework\View\DesignInterface
     */
    protected $design;

    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $page;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Page factory
     *
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $pageFactory;

    /**
     * @var \Magento\Framework\Escaper
     */
    protected $escaper;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    
    /**
     * @var \Magento\Framework\App\CacheInterface
     */
    protected $cache;

    /**
     * @var \Magento\Framework\DataObject
     */
    protected $data;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Cms\Model\Page $page
     * @param \Magento\Framework\View\DesignInterface $design
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\App\CacheInterface $cache
     * @param \Magento\Framework\DataObject $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Cms\Model\Page $page,
        \Magento\Framework\View\DesignInterface $design,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Escaper $escaper,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\CacheInterface $cache,
        \Magento\Framework\DataObject $data
    ) {
        $this->messageManager = $messageManager;
        $this->page = $page;
        $this->design = $design;
        $this->pageFactory = $pageFactory;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper;
        $this->resultPageFactory = $resultPageFactory;
        $this->cache = $cache;
        $this->data = $data;
        parent::__construct($context);
    }

    /**
     * Return result CMS page
     *
     * @param Action $action
     * @param string $block
     * @return \Magento\Framework\View\Result\Page|bool
     */
    public function prepareResultPage(Action $action, $token, $block)
    {
        $cacheId = sprintf('%s_%s', self::CACHE_ID_PREFIX, $token);
        $data = $this->cache->load($cacheId);

        if (false === $data) {
            return;
        }

        $timersCacheId = sprintf('%s_%s', self::CACHE_ID_TIMERS_PREFIX, $token);
        $timers = $this->cache->load($timersCacheId);

        $queriesCacheId = sprintf('%s_%s', self::CACHE_ID_QUERIES_PREFIX, $token);
        $queries = $this->cache->load($queriesCacheId);
      
        if ($block) {

            $this->data->addData(unserialize($data));

            $resultPage = $this->resultPageFactory->create();
            $resultPage->addHandle('mgt_developer_toolbar_view');
            
            $layout = $resultPage->getLayout();
            
            $developerToolbarBlock = $layout->getBlock('mgt_developer_toolbar');
            $developerToolbarBlock->setCollapsible(false);
            $developerToolbarBlock->setToken($token);
            
            $returnToSiteBlock = $layout->getBlock('mgt_developer_toolbar_return_to_site');
            $returnToSiteBlock->setCurrentUrl($this->data->getData('currentUrl'));
            
            $phpParseTimeBlock = $layout->getBlock('mgt_developer_toolbar_block_php_parse_time');
            $phpParseTimeBlock->setPhpParseTime($this->data->getData('phpParseTime'));
            
            $memoryConsumptionBlock = $layout->getBlock('mgt_developer_toolbar_block_memory_consumption');
            $memoryConsumptionBlock->setMemoryConsumption($this->data->getData('memoryConsumption'));
            
            $databaseQueriesBlock = $layout->getBlock('mgt_developer_toolbar_block_database_queries');
            $databaseQueriesBlock->setTotalElapsedSecs($this->data->getData('totalElapsedSecs'));
            $databaseQueriesBlock->setTotalNumQueries($this->data->getData('totalNumberOfQueries'));
            
            $containerBlock = $layout->getBlock('mgt_developer_toolbar_container');
            $containerBlock->setCurrentUrl($this->data->getData('currentUrl'));
            $containerBlock->setControllerModule($this->data->getData('controllerModule'));
            $containerBlock->setControllerClassName($this->data->getData('controllerClassName'));
            $containerBlock->setControllerActionName($this->data->getData('controllerActionName'));
            
            $dashboardContainer = $layout->getBlock('dashboard');
            $dashboardContainer->setAreaCode($this->data->getData('areaCode'));
            
            $requestBlock = $layout->getBlock('request');
            $requestBlock->setGetParameters($this->data->getData('requestGetParameters'));
            $requestBlock->setPostParameters($this->data->getData('requestPostParameters'));
            $requestBlock->setCookies($this->data->getData('cookies'));
            $requestBlock->setRequestAttributes($this->data->getData('requestAttributes'));
            $requestBlock->setRequestHeaders($this->data->getData('requestHeaders'));
            $requestBlock->setServerParameters($this->data->getData('serverParameters'));

            $profilerBlock = $layout->getBlock('profiler');
            
            if ($timers) {
                $timers = unserialize($timers);
                $profilerBlock->setTimers($timers);
            }
            
            $databaseBlock = $layout->getBlock('database');
            
            if ($queries) {
                $queries = unserialize($queries);
                $databaseBlock->setQueries($queries);
                $databaseBlock->setTotalNumberOfQueries($this->data->getData('totalNumberOfQueries'));
                $databaseBlock->setTotalElapsedSecs($this->data->getData('totalElapsedSecs'));
            }
            
            $blocksBlock = $layout->getBlock('blocks');
            $blocksBlock->setBlocks($this->data->getData('blocks'));
            
            $handlesBlock = $layout->getBlock('handles');
            $handlesBlock->setHandles($this->data->getData('layoutHandles'));

            $eventsBlock = $layout->getBlock('events');
            $eventsBlock->setEvents($this->data->getData('events'));
            
            $pluginsBlock = $layout->getBlock('plugins');
            $pluginsBlock->setPlugins($this->data->getData('plugins'));
            
            $preferencesBlock = $layout->getBlock('preferences');
            $preferencesBlock->setPreferences($this->data->getData('preferences'));
            
            $sidebarBlock = $layout->getBlock('mgt_developer_toolbar_container_sidebar');
            if ($sidebarChildBlock = $sidebarBlock->getChildBlock($block)) {
                $sidebarBlock->setActiveBlock($block);
                $sidebarBlock->setToken($token);
            }
        }

        return $resultPage;
    }
}
