<?php

class Wee_Base_Block_Adminhtml_Shop extends Mage_Core_Block_Template
{
    const MGT_SHOP_URL = 'http://www.mgt-commerce.com/';
    
    protected function _toHtml()
    {
        $output = $this->_getStyles();
        $output .= "<iframe id=\"mgtFrame\" scrolling=\"auto\"  src=\"{$this->_getIframeUrl()}\" style=\"width: 100%; height:100%;\"></iframe>";
        return $output;
    }
    
    protected function _getIframeUrl()
    {
      $iframeUrl = sprintf(self::MGT_SHOP_URL.'?sis=%s', Mage::app()->getStore()->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB));
      return $iframeUrl;
    }

    protected function _getStyles()
    {
        $styles = '
          <style type="text/css" media="screen">
            body, html {width: 100%;height: 100%;overflow: hidden;}
            .middle {padding:0px; }
            iframe {display:block; width:100%;height:100%; height:800px !important;border-bottom:0px;}
            .footer, #loading-mask {display:none;}
          </style>
        ';
        return $styles;
    }
}