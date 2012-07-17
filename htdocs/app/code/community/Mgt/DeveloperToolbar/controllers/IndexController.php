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

class Mgt_DeveloperToolbar_IndexController extends Mage_Core_Controller_Front_Action
{
    const SHOP_SCOPE = 'stores';
    
    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost();

            $frontendHintsEnable = false;
            if (isset($postData['frontendHints']) && $postData['frontendHints']) {
                $frontendHintsEnable = true;
            }
          
            Mage::getConfig()->saveConfig('dev/debug/template_hints', $frontendHintsEnable, self::SHOP_SCOPE, Mage::app()->getStore()->getStoreId());
            Mage::getConfig()->saveConfig('dev/debug/template_hints_blocks', $frontendHintsEnable, self::SHOP_SCOPE, Mage::app()->getStore()->getStoreId());
          
            $translateInlineEnabled = false;
            if (isset($postData['translateInline']) && $postData['translateInline']) {
                $translateInlineEnabled = true;
            }

            Mage::getConfig()->saveConfig('dev/translate_inline/active', $translateInlineEnabled, self::SHOP_SCOPE, Mage::app()->getStore()->getStoreId());
  
            if (isset($postData['clearCache']) && $postData['clearCache']) {
                self::clearCache();
            }

            $this->_redirectReferer();
        }
    }
    
    static protected function clearCache()
    {
        Mage::app()->getCacheInstance()->flush();
        Mage::app()->cleanCache();
        Mage::getModel('core/design_package')->cleanMergedJsCss();
        Mage::getModel('catalog/product_image')->clearCache();

        $cacheTypes = array_keys(Mage::helper('core')->getCacheTypes());
        $enable = array();
        foreach ($cacheTypes as $type) {
            $enable[$type] = 0;
        }
        Mage::app()->saveUseCache($enable);
    }
}