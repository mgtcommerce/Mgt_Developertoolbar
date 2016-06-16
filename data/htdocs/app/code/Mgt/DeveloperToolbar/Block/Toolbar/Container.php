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
namespace Mgt\DeveloperToolbar\Block\Toolbar;

use Magento\Framework\View\Element\Template;
use Mgt\DeveloperToolbar\Block\Context;

class Container extends Template
{
    /**
     * @var \Mgt\DeveloperToolbar\Model\Config
     */
    protected $config;

    /**
     * @var String
     */
    protected $currentUrl;
    
    /**
     * @var String
     */
    protected $controllerModule;
    
    /**
     * @var String
     */
    protected $controllerClassName;
    
    /**
     * @var String
     */
    protected $controllerActionName;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context) 
    {
        $this->config = $context->getConfig();
        parent::__construct($context);
    }
    
    public function setCurrentUrl($currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }
    
    public function getCurrentUrl()
    {
        return $this->currentUrl;
    }
    
    public function setControllerModule($controllerModule)
    {
        $this->controllerModule = $controllerModule;
    }
    
    public function getControllerModule()
    {
        return $this->controllerModule;
    }
    
    public function setControllerClassName($controllerClassName)
    {
        $this->controllerClassName = $controllerClassName;
    }
    
    public function getControllerClassName()
    {
        return $this->controllerClassName;
    }
    
    public function setControllerActionName($controllerActionName)
    {
        $this->controllerActionName = $controllerActionName;
    }
    
    public function getControllerActionName()
    {
        return $this->controllerActionName;
    }
}