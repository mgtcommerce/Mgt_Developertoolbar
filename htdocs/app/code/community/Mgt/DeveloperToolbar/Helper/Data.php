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

class Mgt_DeveloperToolbar_Helper_Data extends Mgt_Base_Helper_Data
{
    static public function formatBytes($bytes)  
    { 
        $size = $bytes / 1024; 
        if ($size < 1024) { 
            $size = number_format($size, 2); 
            $size .= ' KB'; 
        } else  { 
            if ($size / 1024 < 1024)  { 
                $size = number_format($size / 1024, 2); 
                $size .= ' MB'; 
            }  
            else if ($size / 1024 / 1024 < 1024) { 
                $size = number_format($size / 1024 / 1024, 2); 
                $size .= ' GB'; 
            }  
        } 
        return $size; 
    }
    
    static public function getMemoryUsage($realUsage = false)
    {
        return memory_get_usage($realUsage);
    }
    
    static public function formatSql($sql)
    {
        return preg_replace('/\b(UPDATE|SET|SELECT|FROM|AS|LIMIT|ASC|COUNT|DESC|WHERE|LEFT JOIN|INNER JOIN|RIGHT JOIN|ORDER BY|GROUP BY|IN|LIKE|DISTINCT|DELETE|INSERT|INTO|VALUES)\b/', '<span class="mgt-developer-toolbar-log-info">\\1</span>', $sql);
    }
    
    static public function getMediaUrl()
    {
    	return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
    }
}