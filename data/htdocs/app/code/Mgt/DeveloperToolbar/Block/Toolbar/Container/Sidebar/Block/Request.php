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
namespace Mgt\DeveloperToolbar\Block\Toolbar\Container\Sidebar\Block;

use Magento\Framework\Module\ModuleList;

use Mgt\DeveloperToolbar\Block\Context;
use Mgt\DeveloperToolbar\Block\Toolbar\Container\Sidebar\Block;

class Request extends Block
{
    /**
     * @var String
     */
    protected $label = 'Request / Response';

    /**
     * @var Array
     */
    protected $getParameters = [];
    
    /**
     * @var Array
     */
    protected $postParameters = [];
    
    /**
     * @var Array
     */
    protected $requestAttributes = [];
    
    /**
     * @var Array
     */
    protected $requestHeaders = [];
    
    /**
     * @var Array
     */
    protected $serverParameters = [];
    
    /**
     * @var Array
     */
    protected $cookies = [];
    
    /**
     * @param Context $context
     * @param ModuleList $moduleList
     */
    public function __construct(
        Context $context
    ) {
        
        parent::__construct($context);
    }
    
    public function setGetParameters(array $getParameters)
    {
        $this->getParameters = $getParameters;
    }
    
    public function getGetParameters()
    {
        return $this->getParameters;
    }
    
    public function setPostParameters(array $postParameters)
    {
        $this->postParameters = $postParameters;
    }
    
    public function getPostParameters()
    {
        return $this->postParameters;
    }
    
    public function setCookies(array $cookies)
    {
        $this->cookies = $cookies;
    }
    
    public function getCookies()
    {
        return $this->cookies;
    }
    
    public function setRequestAttributes(array $requestAttributes)
    {
        $this->requestAttributes = $requestAttributes;
    }
    
    public function getRequestAttributes()
    {
        return $this->requestAttributes;
    }
    
    public function setRequestHeaders(array $requestHeaders)
    {
        $this->requestHeaders = $requestHeaders;
    }
    
    public function getRequestHeaders()
    {
        return $this->requestHeaders;
    }
    
    public function setServerParameters(array $serverParameters)
    {
        $this->serverParameters = $serverParameters;
    }
    
    public function getServerParameters()
    {
        return $this->serverParameters;
    }
}