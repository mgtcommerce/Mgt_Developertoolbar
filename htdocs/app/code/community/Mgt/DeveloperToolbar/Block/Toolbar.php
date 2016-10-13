<?php
/**
 * MGT-Commerce GmbH
 * http://www.mgt-commerce.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@mgt-commerce.com so we can send you a copy immediately.
 *
 * @category    Mgt
 * @package     Mgt_DeveloperToolbar
 * @author      Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 * @copyright   Copyright (c) 2012 (http://www.mgt-commerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mgt_DeveloperToolbar_Block_Toolbar extends Mgt_DeveloperToolbar_Block_Template
{
    const XML_PATH_MGT_DEVELOPERTOOLBAR_ACTIVE = 'default/mgt_developertoolbar/mgt_developertoolbar/active';
    const XML_PATH_MGT_DEVELOPERTOOLBAR_ALLOW_IPS = 'default/mgt_developertoolbar/mgt_developertoolbar/allow_ips';
    
    protected $_items = array();

    public function __construct()
    {
        $this->_addDefaultItems();
    }
    
    protected function _addDefaultItems()
    {
        $this->_addItem(new Mgt_DeveloperToolbar_Block_Toolbar_Item_Version('version'));
        $this->_addItem(new Mgt_DeveloperToolbar_Block_Toolbar_Item_Info('info', 'info'));
        $this->_addItem(new Mgt_DeveloperToolbar_Block_Toolbar_Item_Profiler('profiler', 'profiler'));
        $this->_addItem(new Mgt_DeveloperToolbar_Block_Toolbar_Item_Time('time'));
        $this->_addItem(new Mgt_DeveloperToolbar_Block_Toolbar_Item_Memory('memory'));
        $this->_addItem(new Mgt_DeveloperToolbar_Block_Toolbar_Item_Database('database'));    
    }
    
    protected function _addItem(Mgt_DeveloperToolbar_Block_Toolbar_Item $item)
    {
        $this->_items[] = $item;    
    }
    
    protected function getItems()
    {
        return $this->_items;
    }
    
    public function isActive()
    {
        $isActive = (int)Mage::getConfig()->getNode(self::XML_PATH_MGT_DEVELOPERTOOLBAR_ACTIVE);
        return $isActive;
    }
    
    public function isIpAllowed()
    {
        $allow = true;
        $allowedIps = (string)Mage::getConfig()->getNode(self::XML_PATH_MGT_DEVELOPERTOOLBAR_ALLOW_IPS);
        $remoteAddr = Mage::helper('core/http')->getRemoteAddr();
        if (!empty($allowedIps) && !empty($remoteAddr)) {
          $allowedIps = preg_split('#\s*,\s*#', $allowedIps, null, PREG_SPLIT_NO_EMPTY);
          if (array_search($remoteAddr, $allowedIps) === false && array_search(Mage::helper('core/http')->getHttpHost(), $allowedIps) === false) {
              $allow = false;
          }
        }
        return $allow;
    }
    
    protected function _toHtml()
    {
        $isActive = $this->isActive();
        $isIpAllowed = $this->isIpAllowed();
        if ($isActive && $isIpAllowed) {
            return parent::_toHtml();
        }
    }
}