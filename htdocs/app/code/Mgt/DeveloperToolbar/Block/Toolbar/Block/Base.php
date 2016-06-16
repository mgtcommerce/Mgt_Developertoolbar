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

use Magento\Framework\View\Element\Template;
use Mgt\DeveloperToolbar\Block\Context;

class Base extends Template
{
    /**
     * @var String
     */
    protected $token;
    
    /**
     * @var \Magento\Framework\Url
     */
    protected $urlBuilder;
    
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetaData;
    
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->urlBuilder = $context->getUrl();
        $this->productMetaData = $context->getProductMetaData();
        parent::__construct($context);
    }
    
    public function getToken()
    {
        if (!$this->token) {
            $layout = $this->getLayout();
            $toolbarBlock = $layout->getBlock('mgt_developer_toolbar');
            $this->token = $toolbarBlock->getToken();
        } 
        return $this->token;
    }
    
    public function getUrlBuilder()
    {
        return $this->urlBuilder;
    }
    
    public function getProductMetaData()
    {
        return $this->productMetaData;
    }
}
