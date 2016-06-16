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
namespace Mgt\DeveloperToolbar\Block\Toolbar\Container;

use Magento\Framework\View\Element\Template;
use Mgt\DeveloperToolbar\Block\Context;

class Sidebar extends Template
{
    /**
     * @var \Mgt\DeveloperToolbar\Model\Config
     */
    protected $config;
    
    /**
    * @var string
    */
    protected $activeBlock = 'dashboard';
    
    /**
     * @var string
     */
    protected $token = 'token';

    /**
     * @param Context $context
     * @param Config $config
     */
    public function __construct(
        Context $context) 
    {
        $this->config = $context->getConfig();
        parent::__construct($context);
    }
    
    public function setActiveBlock($activeBlock)
    {
        $this->activeBlock = $activeBlock;
    }
    
    public function getActiveBlock()
    {
        return $this->activeBlock;
    }
    
    public function setToken($token)
    {
        $this->token = $token;
    }
    
    public function getToken()
    {
        return $this->token;
    }
}