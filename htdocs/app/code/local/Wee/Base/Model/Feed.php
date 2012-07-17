<?php

class Wee_Base_Model_Feed extends Mage_AdminNotification_Model_Feed
{
    const XML_INTERESTS      = 'system/wee_base/interests';
    const XML_FEED_URL_PATH  = 'system/wee_base/feed_url';
    const TYPE_NEW_RELEASE   = 'NEW_RELEASE';
    const TYPE_MODULE_UPDATE = 'MODULE_UPDATE';
    const TYPE_INFO          = 'INFO';
    
    public function checkUpdate()
    {
        $frequency = $this->getFrequency();
        $lastUpdate = $this->getLastUpdate();
        $interests = self::getInterests();
        
        if ((($frequency + $lastUpdate) > time()) || (!count($interests))) {
            return $this;
        }

        $feedData = array();
        $feedXml = $this->getFeedData();
        if ($feedXml && isset($feedXml->channel) && isset($feedXml->channel->item)) {
            
            $timeOfInstallation = gmdate('Y-m-d H:i:s', Mage::getStoreConfig('wee_base/feed/installed'));
            
            foreach ($feedXml->channel->item as $item) {
                $date = $this->getDate((string)$item->pubDate);
                $canAddItem = $this->_canAddItem($item);
                if (!$canAddItem || $date < $timeOfInstallation) {
                    continue;
                }
                
                $feedData[] = array(
                    'severity'      => (int)$item->severity ? (int)$item->severity : 3,
                    'date_added'    => $date,
                    'title'         => (string)$item->title,
                    'description'   => (string)$item->description,
                    'url'           => (string)$item->link,
                );
            }
            if ($feedData) {
                Mage::getModel('adminnotification/inbox')->parse($feedData);
            }
        }
        $this->setLastUpdate();
    }
    
    public function getFeedData()
    {
        $xml = '';
        try {
            $client = new Zend_Http_Client($this->getFeedUrl());
            $client->setConfig(array('maxredirects' => 0, 'timeout' => 5));
            $data = $client->request(Zend_Http_Client::GET);
            if ($data = $data->getBody()) {
                $xml  = new SimpleXMLElement($data);
            }
        }
        catch (Exception $e) {
            return false;
        }

        return $xml;
    }
    
    static protected function _canAddItem(SimpleXMLElement $item)
    {
        $canAdd = false;
        $interests = self::getInterests();
        $itemType = (string)$item->type;
        $module = (string)$item->module;
        if (in_array($itemType, $interests)) {
            if ($itemType == self::TYPE_MODULE_UPDATE) {
                $isModuleInstalled = self::_isModuleInstalled($module);
                $canAdd = $isModuleInstalled ? true : false;
            } else {
                $canAdd = true;
            }
        }
        return $canAdd;
    }

    public function getLastUpdate()
    {
        return Mage::app()->loadCache('wee_base_feed_lastcheck');
    }

    public function getFeedUrl()
    {
        $feedUrl = Mage::getStoreConfig(self::XML_FEED_URL_PATH);
        return $feedUrl;
    }
    
    static public function getInterests()
    {
        $interests = array();
        $interestsConfig = trim(Mage::getStoreConfig(self::XML_INTERESTS));
        if ($interestsConfig) {
            $interests = explode(',', $interestsConfig);
        }
        return $interests;
    }

    public function setLastUpdate()
    {
        Mage::app()->saveCache(time(), 'wee_base_feed_lastcheck');
        return $this;
    }
    
    static public function check()
    {
        return Mage::getModel('wee_base/feed')->checkUpdate();
    }
    
    static protected function _isModuleInstalled($moduleCode)
    {
        if ($moduleCode) {
            $modules = (array)Mage::getConfig()->getNode('modules')->children();
            return isset($modules[$moduleCode]);
        }
        return false;
    }
}