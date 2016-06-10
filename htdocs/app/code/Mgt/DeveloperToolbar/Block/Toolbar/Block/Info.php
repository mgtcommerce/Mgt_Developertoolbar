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
namespace Mgt\DeveloperToolbar\Block\Toolbar\Block;

use Mgt\DeveloperToolbar\Block\Context;
use Magento\Framework\App\Request\Http as Request;
use Magento\Framework\Registry;

class Info extends Base
{
    const CONTROLLER_ACTION_NAME = 'execute';
    
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;
    
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @param Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Context $context,
        Request $request,
        Registry $registry
    ) {
        $this->request = $request;
        $this->registry = $registry;
        parent::__construct($context);
    }
    
    public function getMode()
    {
        return $this->_appState->getMode();
    }
    
    public function getControllerModule()
    {
        return $this->request->getControllerModule();
    }
    
    public function getControllerClassName()
    {
        return $this->registry->registry('mgt_developer_toolbar_class_name');
    }
    
    public function getControllerActionName()
    {
        return self::CONTROLLER_ACTION_NAME;
    }
}
