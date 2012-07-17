<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Wee
 * @package     Wee_DeveloperToolbar
 * @author      Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 * @copyright   Copyright (c) 2011 (http://www.mgt-commerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mgt_DeveloperToolbar_Block_Tab_Events extends Mgt_DeveloperToolbar_Block_Tab
{
    const CACHE_LIFETIME = 15000;
    const CACHE_KEY = 'DEVELOPER_TOOLBAR_TAB_EVENTS';

    protected $_eventAreas = array('global', 'adminhtml', 'frontend');
    protected $_events = array();
    
    public function __construct($name, $label)
    {
        parent::__construct($name, $label);
        $this->setTemplate('wee_developertoolbar/tab/events.phtml');
        $this->addData(array(
            'cache_key'      => self::CACHE_KEY,
            'cache_lifetime' => self::CACHE_LIFETIME,
        ));
    }

    public function getEvents()
    {
        if (!$this->_events) {
        	Varien_Profiler::start('muha');
            foreach ($this->_eventAreas as $eventArea) {
                $eventConfig = Mage::app()->getConfig()->getNode(sprintf('%s/events', $eventArea));
                if ($eventConfig instanceof Mage_Core_Model_Config_Element) {
                   $areaEvents = $eventConfig->children();
                   foreach ($areaEvents as $eventName => $event) {
                       foreach ($event->observers->children() as $observerName => $observer) {
                           $observerData = array(
                               'name' => $observerName,
                               'class' => Mage::app()->getConfig()->getModelClassName($observer->class),
                               'method' => (string)$observer->method
                          );
                          $this->_events[$eventArea][$eventName]['observer'][] = new Varien_Object($observerData);
                       }
                   }
                }
            }
            Varien_Profiler::stop('muha');
        }
        return $this->_events;
    }
}