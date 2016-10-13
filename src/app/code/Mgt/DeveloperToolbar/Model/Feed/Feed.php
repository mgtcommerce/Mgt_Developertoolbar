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
namespace Mgt\DeveloperToolbar\Model\Feed;

use Magento\Framework\Config\ConfigOptionsListConstants;

class Feed extends \Magento\Framework\Model\AbstractModel
{
    const FEED_URL = 'http://feed.mgt-commerce.com/';
    const UPDATE_FREQUENCY = 21600; // 6 hours
    const SEVERITY_INFORMATION = 4;

    /**
     * @var \Magento\Backend\App\ConfigInterface
     */
    protected $backendConfig;

    /**
     * @var \Magento\AdminNotification\Model\InboxFactory
     */
    protected $inboxFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     *
     */
    protected $storeManager;

    /**
     * Deployment configuration
     *
     * @var \Magento\Framework\App\DeploymentConfig
     */
    protected $deploymentConfig;

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\ConfigInterface $backendConfig
     * @param \Magento\AdminNotification\Model\InboxFactory $inboxFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\DeploymentConfig $deploymentConfig
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\ConfigInterface $backendConfig,
        \Magento\AdminNotification\Model\InboxFactory $inboxFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->backendConfig     = $backendConfig;
        $this->inboxFactory      = $inboxFactory;
        $this->storeManager      = $storeManager;
        $this->deploymentConfig  = $deploymentConfig;
        $this->productMetadata   = $productMetadata;
        $this->urlBuilder        = $urlBuilder;
    }

    /**
     * Init model
     *
     * @return void
     */
    protected function _construct()
    {
    }

    /**
     * Check feed for modification
     *
     * @return $this
     */
    public function checkUpdate()
    {
        $frequency = $this->getFrequency();
        $lastUpdate = $this->getLastUpdate();

        if ($frequency + $lastUpdate > time()) {
            return $this;
        }

        $feedData = [];
        $feedXml = $this->getFeedData();
        $installDate = strtotime($this->deploymentConfig->get(ConfigOptionsListConstants::CONFIG_PATH_INSTALL_DATE));

        if ($feedXml && isset($feedXml->channel) && isset($feedXml->channel->item)) {
            foreach ($feedXml->channel->item as $item) {
                $itemPublicationDate = strtotime((string)$item->pubDate);
                if ($installDate <= $itemPublicationDate) {
                    $feedData[] = [
                        'severity'    => self::SEVERITY_INFORMATION,
                        'date_added'  => date('Y-m-d H:i:s', $itemPublicationDate),
                        'title'       => (string)$item->title,
                        'description' => (string)$item->description,
                        'url'         => (string)$item->link,
                    ];
                }
            }

            if ($feedData) {
                $this->inboxFactory->create()->parse(array_reverse($feedData));
            }
        }

        $this->setLastUpdate();

        return $this;
    }

    /**
     * Retrieve Update Frequency
     *
     * @return int
     */
    public function getFrequency()
    {
        return self::UPDATE_FREQUENCY;
    }

    /**
     * Retrieve Last update time
     *
     * @return int
     */
    public function getLastUpdate()
    {
        return $this->_cacheManager->load('mgt_feed_admin_notifications_lastcheck');
    }

    /**
     * Set last update time (now)
     *
     * @return $this
     */
    public function setLastUpdate()
    {
        $this->_cacheManager->save(time(), 'mgt_feed_admin_notifications_lastcheck');
        return $this;
    }

    /**
     * Retrieve feed data as XML element
     *
     * @return \SimpleXMLElement
     */
    public function getFeedData()
    {
        try {
            $xml = '';
            $postParams = [
                'shop_url' => $this->storeManager->getStore()->getBaseUrl(),
                'version'  => $this->productMetadata->getVersion(),
            ];
            $client = new \Zend_Http_Client(self::FEED_URL);
            $client->setParameterPost($postParams);
            $client->setConfig(array('maxredirects' => 0, 'timeout' => 30));
            $data = $client->request(\Zend_Http_Client::POST);
            if ($data = $data->getBody()) {
                $xml = new \SimpleXMLElement($data);
            }
        } catch (\Exception $e) {
            return false;
        }
        return $xml;
    }
}
