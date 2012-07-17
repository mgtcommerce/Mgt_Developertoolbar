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

class Mgt_DeveloperToolbar_Block_Toolbar_Item_Database extends Mgt_DeveloperToolbar_Block_Toolbar_Item
{
    protected $_profiler;
    
    public function __construct($name, $label = '')
    {
        parent::__construct($name, $label);
        $this->setIcon(Mage::helper('mgt_developertoolbar')->getMediaUrl().'mgt_developertoolbar/database.png');
        $this->_content = new Mgt_DeveloperToolbar_Block_TabContainer_Database('database');
    }

    public function getLabel()
    {
        $profiler = $this->_getProfiler();
        return $profiler->getTotalNumQueries();
    }
    
    protected function _getProfiler()
    {
        if (!$this->_profiler) {
           $this->_profiler = Mage::getSingleton('core/resource')->getConnection('core_write')->getProfiler();
        }
        return $this->_profiler;
    }
}