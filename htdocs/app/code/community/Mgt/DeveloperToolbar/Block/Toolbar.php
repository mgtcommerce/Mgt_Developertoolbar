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

class Mgt_DeveloperToolbar_Block_Toolbar extends Mgt_DeveloperToolbar_Block_Template
{
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
    
    protected function _addItem(Wee_DeveloperToolbar_Block_Toolbar_Item $item)
    {
        $this->_items[] = $item;    
    }
    
    protected function getItems()
    {
        return $this->_items;
    }
}