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

class Mgt_DeveloperToolbar_Block_Tab_Request extends Mgt_DeveloperToolbar_Block_Tab
{
    protected $_request;
    protected $_frontController;
    
    public function __construct($name, $label)
    {
        parent::__construct($name, $label);
        $this->setTemplate('mgt_developertoolbar/tab/request.phtml');
        $this->setIsActive(true);
        $this->_request = Mage::app()->getRequest();
        $this->_frontController = Mage::app()->getFrontController();
    }

    public function getFrontControllerName()
    {
        return get_class($this->_frontController->getAction());
    }
    
    public function getControllerModuleName()
    {
        return $this->_request->getControllerModule();
    }
    
    public function getControllerActionName()
    {
        return $this->_request->getActionName();
    }
    
    public function getParams()
    {
        return $this->_request->getParams();
    }
}