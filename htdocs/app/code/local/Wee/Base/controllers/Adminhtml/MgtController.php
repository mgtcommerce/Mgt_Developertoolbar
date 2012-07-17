<?php

class Wee_Base_Adminhtml_MgtController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('System'))
             ->_title($this->__('Mgt-Commerce-.com'));
        $this->loadLayout();
        $this->_setActiveMenu('mgtcommerce');
        $this->_addContent($this->getLayout()->createBlock('wee_base_adminhtml/shop', 'mgt-commerce.com'));
        $this->renderLayout();
    }

    protected function _addContent(Mage_Core_Block_Abstract $block)
    {
        $this->getLayout()->getBlock('content')->append($block);
    }
    
}
